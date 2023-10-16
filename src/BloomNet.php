<?php

namespace BloomNetwork;

use BloomNetwork\Exceptions\InvalidResponseException;
use BloomNetwork\Models\CreateOrderRequest;
use BloomNetwork\Models\Credentials;
use BloomNetwork\Models\DeliveryDateByLocationRequest;
use BloomNetwork\Models\GetMemberDirectoryRequest;
use BloomNetwork\Models\IsAvailableByLocationAndDate;
use BloomNetwork\Models\Responses\AvailableShopResponse;
use BloomNetwork\Models\RetrieveMessagesRequest;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Promise\Utils;

class BloomNet
{
    private static string $test_endpoint = 'https://qa.bloomlink.net/fsiv2/processor';

    private static $prod_endpoint = "http://www.bloomlink.net/fsiv2/processor";

    private Client $http;

    private string $username;

    private string $password;

    private string $shopcode;

    private Credentials $credentials;

    public function __construct(string $username, string $password, string $shopcode, bool $isProduction = false)
    {
        $this->http = new Client(
            ['base_uri' => $isProduction ? self::$prod_endpoint : self::$test_endpoint]
        );
        $this->username = $username;
        $this->password = $password;
        $this->shopcode = $shopcode;

        $this->credentials = new Credentials(
            $this->username,
            $this->password,
            $this->shopcode,
        );
    }

    protected function request()
    {

    }

    public function getMemberDirectory()
    {
        return $this->http->get('/fsiv2/processor', [
            'query' => [
                'func' => 'getMemberDirectory',
                'data' => (new GetMemberDirectoryRequest($this->credentials))->xml(),
            ],
        ]);
    }

    public function sendOrder(CreateOrderRequest $request)
    {
        return $this->http->get('/fsiv2/processor', [
            'query' => [
                'func' => 'postmessages',
                'data' => $request,
            ],
        ]);
    }

    public function isAvaliableForDeliveryOnDateAndZipCode(Carbon $delivery_date, string $zip_code)
    {
        $response = $this->http->get('/fsiv2/processor', [
            'query' => [
                'func' => 'getMemberDirectory',
                'data' => (new DeliveryDateByLocationRequest(
                    new Credentials(
                        $this->username,
                        $this->password,
                        $this->shopcode
                    ),
                    $delivery_date,
                    $zip_code
                ))->xml(),
            ],
        ]);

        $handle = new IsAvailableByLocationAndDate($response);

        return $handle->response();
    }

    /**
     * @return array{string: bool}
     *
     * @throws InvalidResponseException
     * @throws \Throwable
     */
    public function deliveryDatesForZipCode(CarbonPeriod $period, string $zip_code): array
    {
        $promises = [];
        foreach ($period as $date) {
            $promises[$date->format('Y-m-d')] = $this->http->getAsync('/fsiv2/processor', [
                'query' => [
                    'func' => 'getMemberDirectory',
                    'data' => (new DeliveryDateByLocationRequest(
                        new Credentials(
                            $this->username,
                            $this->password,
                            $this->shopcode
                        ),
                        $date,
                        $zip_code
                    ))->xml(),
                ],
            ]);
        }


        $responses = Utils::unwrap($promises);

        return array_map(fn ($response) => (new IsAvailableByLocationAndDate($response))->response(), $responses);
    }

    /**
     * Returns shop codes that are available for delivery on a given date and zip code.
     *
     * @throws InvalidResponseException
     * @throws GuzzleException
     */
    public function availableShops(Carbon $delivery_date, string $zip_code): string
    {
        $response = $this->http->get('/fsiv2/processor', [
            'query' => [
                'func' => 'getMemberDirectory',
                'data' => (new DeliveryDateByLocationRequest(
                    new Credentials(
                        $this->username,
                        $this->password,
                        $this->shopcode
                    ),
                    $delivery_date,
                    $zip_code
                ))->xml(),
            ],
        ]);

        $handle = new AvailableShopResponse($response);

        return $handle->response();
    }

    public function retrieveMessages()
    {
        $response = $this->http->get('/fsiv2/processor', [
            'query' => [
                'func' => 'getmessages',
                'data' => (new RetrieveMessagesRequest(
                    new Credentials(
                        $this->username,
                        $this->password,
                        $this->shopcode
                    )
                ))->xml(),
            ],
        ]);

        dd($response->getBody()->getContents());
    }
}

<?php

namespace BloomNetwork;

use BloomNetwork\Exceptions\InvalidResponseException;
use BloomNetwork\Models\CreateOrderRequest;
use BloomNetwork\Models\Credentials;
use BloomNetwork\Models\DeliveryDateByLocationRequest;
use BloomNetwork\Models\GetMemberDirectoryRequest;
use BloomNetwork\Models\IsAvailableByLocationAndDate;
use BloomNetwork\Models\Responses\AvailableShopResponse;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class BloomNet
{
    private static string $endpoint = 'https://qa.bloomlink.net/fsiv2/processor';

    //private static $endpoint = "http://www.bloomlink.net/fsiv2/processor";

    private Client $http;

    private string $username;

    private string $password;

    private string $shopcode;

    private Credentials $credentials;

    public function __construct(string $username, string $password, string $shopcode)
    {
        $this->http = new Client(
            ['base_uri' => self::$endpoint]
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

    public function retrieveMessages()
    {
        return $this->http->get('/', [
            'query' => [
                'func' => 'getmessages',
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
}

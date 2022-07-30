<?php namespace BloomNetwork;

use GuzzleHttp\Client;

class BloomNet
{
    private static string $endpoint = "https://qa.bloomlink.net/fsiv2/processor";

    //private static $endpoint = "http://www.bloomlink.net/fsiv2/processor";

    /**
     * @var \GuzzleHttp\Client
     */
    private Client $http;

    public function __construct()
    {
        $this->http = new Client(
            ['base_uri' => self::$endpoint]
        );
    }

    protected function request()
    {

    }

    public function retrieveMessages()
    {
        return $this->http->get('/', [
            'query' => [
                'func' => 'getmessages',
            ],
        ]);
    }

    public function sendOrder($stub)
    {
        return $this->http->get('/fsiv2/processor', [
            'query' => [
                'func' => 'postmessages',
                'data' => file_get_contents($stub)
            ],
        ]);
    }
}
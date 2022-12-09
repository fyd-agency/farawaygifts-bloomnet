<?php

namespace BloomNetwork\Models;

use BloomNetwork\Exceptions\InvalidResponseException;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Psr7\Response;
use SimpleXMLElement;

class AbstractResponse
{
    protected SimpleXMLElement $response;

    /**
     * @throws InvalidResponseException
     */
    public function __construct(Response $response)
    {
        $xml_string = (string)$response->getBody();

        $data = simplexml_load_string($xml_string);

        if ($data === false) {
            throw new InvalidResponseException();
        }

        $this->response = $data;
    }
}
<?php

namespace BloomNetwork\Models;

use Spatie\ArrayToXml\ArrayToXml;

class RetrieveMessagesRequest implements XmlFormatter
{
    private Credentials $credentials;

    public function __construct(Credentials $credentials)
    {
        $this->credentials = $credentials;
    }

    public function xml(): string
    {
        return str_replace('<?xml version="1.0"?>\n', '', ArrayToXml::convert([
            'security' => $this->credentials->toArray(),
            'fulfillerShopCode' => $this->credentials->getShopCode(),
            'systemType' => 'General',
        ], 'foreignSystemInterfaceOutboundRequest'));
    }
}

<?php

namespace BloomNetwork\Models;

use Spatie\ArrayToXml\ArrayToXml;

class GetMemberDirectoryRequest implements XmlFormatter
{
    private Credentials $credentials;

    public function __construct(Credentials $credentials)
    {
        $this->credentials = $credentials;
    }

    public function xml(): string
    {
        return ArrayToXml::convert([
            'searchShopRequest' => [
                'security' => $this->credentials->toArray(),
                'memberDirectorySearchOptions' => [
                    'searchAll' => []
                ]
            ]
        ], 'memberDirectoryInterface');
    }
}
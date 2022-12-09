<?php

namespace BloomNetwork\Models\Items\Shops;

class Address
{
    public function __construct(
        public string $attention,
        public string $addressLine1,
        public string $addressLine2,
        public string $city,
        public string $state,
        public string $zip,
        public string $country
    )
    {

    }
}
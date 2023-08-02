<?php

namespace BloomNetwork\Models\Items;

class Recipient
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $address1,
        public string $city,
        public string $state,
        public string $zip,
        public string $country,
        public string $phoneNumber,

        public ?string $attention,
        public ?string $address2,
    ) {
    }
}

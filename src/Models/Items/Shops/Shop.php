<?php

namespace BloomNetwork\Models\Items\Shops;

use phpDocumentor\Reflection\Types\Boolean;

class Shop
{
    public bool $is_open_sunday;

    public function __construct(
        public string $shopCode,
        public string $name,
        public Address $address,
        string $sundayIndicator,
        public string $phoneNumber,
        public string $email,
        public string $shopStatus,
    ) {
        $this->is_open_sunday = $sundayIndicator == 'Y';
    }
}
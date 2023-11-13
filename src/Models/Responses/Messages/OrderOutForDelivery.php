<?php

namespace BloomNetwork\Models\Responses\Messages;

use Carbon\Carbon;

class OrderOutForDelivery
{
    public function __construct(
        public string $fulfillingShopCode,
        public string $orderNumber,
        public Carbon $messageTimestamp,
        public Carbon $loadedDate,
        public string $bloomnetOrderNumber = '',
    )
    {
    }
}
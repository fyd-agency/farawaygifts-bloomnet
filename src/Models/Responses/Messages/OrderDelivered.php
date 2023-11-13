<?php

namespace BloomNetwork\Models\Responses\Messages;

use Carbon\Carbon;

class OrderDelivered
{
    public function __construct(
        public string $fulfillingShopCode,
        public string $orderNumber,
        public Carbon $messageTimestamp,
        public Carbon $deliveredDate,
        public string $bloomnetOrderNumber = '',
        public string $signature = '',
    )
    {
    }
}
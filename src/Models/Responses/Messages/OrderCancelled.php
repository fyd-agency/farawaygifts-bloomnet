<?php

namespace BloomNetwork\Models\Responses\Messages;

use Carbon\Carbon;

class OrderCancelled
{
    public function __construct(
        public string $fulfillingShopCode,
        public string $orderNumber,
        public Carbon $messageTimestamp,
        public string $bloomnetOrderNumber = '',
        public string $reason = '',
    )
    {
    }
}
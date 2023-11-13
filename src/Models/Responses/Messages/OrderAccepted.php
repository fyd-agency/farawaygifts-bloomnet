<?php

namespace BloomNetwork\Models\Responses\Messages;

use Carbon\Carbon;

class OrderAccepted
{
    public function __construct(
        public string $fulfillmentShopCode,
        public Carbon $messageTimestamp,
        public string $orderNumber = '',
        public string $bloomnetOrderNumber = '',
    )
    {
    }
}
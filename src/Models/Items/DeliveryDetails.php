<?php

namespace BloomNetwork\Models\Items;

use Carbon\Carbon;

class DeliveryDetails
{
    public function __construct(
        public Carbon $deliveryDate,
        public string $specialInstruction,
    ) {
    }
}

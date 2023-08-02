<?php

namespace BloomNetwork\Models;

class IsAvailableByLocationAndDate extends AbstractResponse
{
    public function response(): bool
    {
        $shopResponse = $this->response->searchShopResponse;

        return (
            ! is_null($shopResponse->shops->shop) && count($this->response->searchShopResponse->shops->shop) >= 1) ||
            !empty($shopResponse->shopCode);
    }
}

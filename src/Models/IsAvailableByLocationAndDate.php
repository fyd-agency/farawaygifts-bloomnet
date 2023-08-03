<?php

namespace BloomNetwork\Models;

class IsAvailableByLocationAndDate extends AbstractResponse
{
    public function response(): bool
    {
        $shopResponse = $this->response->searchShopResponse;

        if (isset($shopResponse->errors->error)) {
            return false;
        }

        return (
            ! is_null($shopResponse->shops->shop) && count($this->response->searchShopResponse->shops->shop) >= 1) ||
            count($shopResponse->shopCodes->code) > 1 ||
            ! empty($shopResponse->shopCode);
    }
}

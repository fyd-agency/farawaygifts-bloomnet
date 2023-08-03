<?php

namespace BloomNetwork\Models\Responses;

use BloomNetwork\Models\AbstractResponse;

class AvailableShopResponse extends AbstractResponse
{
    public function response(): string
    {
        return $this->response->searchShopResponse->shopCode;
    }
}

<?php

namespace BloomNetwork\Models;

use Carbon\Carbon;
use GuzzleHttp\Psr7\Response;
use Spatie\ArrayToXml\ArrayToXml;

class IsAvailableByLocationAndDate extends AbstractResponse
{
    public function response(): bool
    {
        return !is_null($this->response->searchShopResponse->shops->shop) && count($this->response->searchShopResponse->shops->shop) > 1;
    }
}
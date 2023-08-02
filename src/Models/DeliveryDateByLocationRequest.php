<?php

namespace BloomNetwork\Models;

use Carbon\Carbon;
use Spatie\ArrayToXml\ArrayToXml;

final class DeliveryDateByLocationRequest implements XmlFormatter
{
    private Carbon $delivery_date;

    private string $zip_code;

    private Credentials $credentials;

    public function __construct(Credentials $credentials, Carbon $delivery_date, string $zip_code)
    {
        $this->delivery_date = $delivery_date;
        $this->zip_code = $zip_code;
        $this->credentials = $credentials;
    }

    public function xml(): string
    {
        return ArrayToXml::convert([
            'searchShopRequest' => [
                'security' => [
                    'username' => $this->credentials->getUsername(),
                    'password' => $this->credentials->getPassword(),
                    'shopCode' => $this->credentials->getShopCode(),
                ],
                'memberDirectorySearchOptions' => [
                    'searchAvailability' => [
                        'deliveryDate' => $this->delivery_date->format('m/d/Y'),
                        'zipCode' => $this->zip_code,
                    ],
                ],
            ],
        ], 'memberDirectoryInterface');
    }
}

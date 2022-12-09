<?php

use BloomNetwork\Models\CreateOrderRequest;
use BloomNetwork\Models\Items\DeliveryDetails;
use BloomNetwork\Models\Items\OrderProductionInfo;
use BloomNetwork\Models\Items\Recipient;
use PHPUnit\Framework\TestCase;

class CreateOrderRequestTest extends TestCase
{
    public function testToXml(): void
    {
        $request = new CreateOrderRequest(
            new Recipient(
                'John',
                'Doe',
                '123 Fake Street',
                'Someplace',
                'IL',
                '55555',
                'USA',
                '555-555-5555'
            ),
            [
               new OrderProductionInfo(
                   1,
                   10.00,
                   "Lots of Roses"
               )
            ],
            new DeliveryDetails(
                \Carbon\Carbon::today(),
                'Special Instructions Here'
            ),
            5.00
        );

        dd($request->xml()->saveHTML());
    }
}
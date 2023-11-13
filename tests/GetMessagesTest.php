<?php

use BloomNetwork\BloomNet;
use PHPUnit\Framework\TestCase;

class GetMessagesTest extends TestCase
{
    protected BloomNet $bloom;

    public function setUp(): void
    {
        $this->bloom = new BloomNet('M682', 'FAIRY', 'M6820000', true);

        parent::setUp(); // TODO: Change the autogenerated stub
    }

    public function testRetrievingMessages()
    {
        $item = $this->bloom->retrieveMessages();

        dd((string) $item->getBody());
    }
}

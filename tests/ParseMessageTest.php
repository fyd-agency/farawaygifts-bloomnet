<?php


use BloomNetwork\Models\MessageTypeParser;
use BloomNetwork\Models\Responses\Messages\OrderAccepted;
use BloomNetwork\Models\Responses\Messages\OrderCancelled;
use BloomNetwork\Models\Responses\Messages\OrderDelivered;
use BloomNetwork\Models\Responses\Messages\OrderOutForDelivery;
use BloomNetwork\Models\Responses\Messages\OrderRejected;
use PHPUnit\Framework\TestCase;

class ParseMessageTest extends TestCase
{

    public function testOrderAcceptedMessage()
    {
        $xml = simplexml_load_file(__DIR__ . '/stubs/messages/order_accepted.xml');

        $messages = $xml->messagesOnOrder;

        $message = MessageTypeParser::parse($messages[0]);

        $this->assertInstanceOf(OrderAccepted::class, $message);
        $this->assertEquals('B1110000', $message->fulfillmentShopCode);
        $this->assertEquals('68683428', $message->bloomnetOrderNumber);
        $this->assertEquals('', $message->orderNumber);
        $this->assertEquals('2006-02-04 05:06:07', $message->messageTimestamp->format('Y-m-d H:i:s'));
    }

    public function testOrderCanceledMessage()
    {
        $xml = simplexml_load_file(__DIR__ . '/stubs/messages/order_canceled.xml');

        $messages = $xml->messagesOnOrder;

        $message = MessageTypeParser::parse($messages[0]);

        $this->assertInstanceOf(OrderCancelled::class, $message);
        $this->assertEquals('B1110000', $message->fulfillingShopCode);
        $this->assertEquals('10000', $message->orderNumber);
        $this->assertEquals('2006-06-04 05:06:07', $message->messageTimestamp->format('Y-m-d H:i:s'));
        $this->assertEquals('', $message->bloomnetOrderNumber);
        $this->assertEquals('I have to cancel this order', $message->reason);
    }

    public function testOrderRejectedMessage()
    {
        $xml = simplexml_load_file(__DIR__ . '/stubs/messages/order_rejected.xml');

        $messages = $xml->messagesOnOrder;

        $message = MessageTypeParser::parse($messages[0]);

        $this->assertInstanceOf(OrderRejected::class, $message);

        $this->assertEquals('B1110000', $message->fulfillingShopCode);
        $this->assertEquals('', $message->orderNumber);
        $this->assertEquals('2006-02-04 05:06:07', $message->messageTimestamp->format('Y-m-d H:i:s'));
        $this->assertEquals('68683426', $message->bloomnetOrderNumber);
        $this->assertEquals('Order can not be delivered. We have to reject this order.', $message->reason);
    }

    public function testOrderOutForDelivery()
    {
        $xml = simplexml_load_file(__DIR__ . '/stubs/messages/order_out_for_delivery.xml');

        $messages = $xml->messagesOnOrder;

        $message = MessageTypeParser::parse($messages[0]);

        $this->assertInstanceOf(OrderOutForDelivery::class, $message);

        $this->assertEquals('B1110000', $message->fulfillingShopCode);
        $this->assertEquals('', $message->orderNumber);
        $this->assertEquals('2006-04-02 05:06:07', $message->messageTimestamp->format('Y-m-d H:i:s'));
        $this->assertEquals('2006-04-02 05:06:02', $message->loadedDate->format('Y-m-d H:i:s'));
        $this->assertEquals('68683417', $message->bloomnetOrderNumber);
    }

    public function testOrderDelivered()
    {
        $xml = simplexml_load_file(__DIR__ . '/stubs/messages/order_delivered.xml');

        $messages = $xml->messagesOnOrder;

        $message = MessageTypeParser::parse($messages[0]);

        $this->assertInstanceOf(OrderDelivered::class, $message);

        $this->assertEquals('P3020000', $message->fulfillingShopCode);
        $this->assertEquals('', $message->orderNumber);
        $this->assertEquals('2006-04-02 05:06:07', $message->messageTimestamp->format('Y-m-d H:i:s'));
        $this->assertEquals('2006-04-02 05:06:07', $message->deliveredDate->format('Y-m-d H:i:s'));
        $this->assertEquals('68683417', $message->bloomnetOrderNumber);
        $this->assertEquals('igor', $message->signature);
    }
}
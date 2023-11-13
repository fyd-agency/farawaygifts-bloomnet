<?php

namespace BloomNetwork\Models;

use _PHPStan_dfcaa3082\Nette\Neon\Exception;
use BloomNetwork\Models\Responses\Messages\OrderAccepted;
use BloomNetwork\Models\Responses\Messages\OrderCancelled;
use BloomNetwork\Models\Responses\Messages\OrderDelivered;
use BloomNetwork\Models\Responses\Messages\OrderOutForDelivery;
use BloomNetwork\Models\Responses\Messages\OrderRejected;
use Carbon\Carbon;
use SimpleXMLElement;

class MessageTypeParser
{
    public static function parse(SimpleXMLElement $message): OrderAccepted|OrderCancelled|OrderRejected|OrderOutForDelivery|OrderDelivered
    {
        if (isset($message->messageAckf)) {
            return new OrderAccepted(
                $message->messageAckf->fulfillingShopCode,
                Carbon::parse($message->messageAckf->messageCreateTimestamp),
                $message->messageAckf->identifiers->generalIdentifiers->externalShopOrderNumber,
                $message->messageAckf->identifiers->generalIdentifiers->bmtOrderNumber,
            );
        }

        if (isset($message->messageCanc)) {
            return new OrderCancelled(
                $message->messageCanc->fulfillingShopCode,
                $message->messageCanc->identifiers->generalIdentifiers->externalShopOrderNumber,
                Carbon::parse($message->messageCanc->messageCreateTimestamp),
                $message->messageCanc->identifiers->generalIdentifiers->bmtOrderNumber,
                $message->messageCanc->messageText,
            );
        }

        if (isset($message->messageRjct)) {
            return new OrderRejected(
                $message->messageRjct->fulfillingShopCode,
                $message->messageRjct->identifiers->generalIdentifiers->externalShopOrderNumber,
                Carbon::parse($message->messageRjct->messageCreateTimestamp),
                trim($message->messageRjct->identifiers->generalIdentifiers->bmtOrderNumber),
                $message->messageRjct->messageText,
            );
        }

        if (isset($message->messageDlou)) {
            return new OrderOutForDelivery(
                $message->messageDlou->fulfillingShopCode,
                $message->messageDlou->identifiers->generalIdentifiers->externalShopOrderNumber,
                Carbon::parse($message->messageDlou->messageCreateTimestamp),
                Carbon::parse($message->messageDlou->loadedDate),
                $message->messageDlou->identifiers->generalIdentifiers->bmtOrderNumber,
            );
        }

        if (isset($message->messageDlcf)) {
            return new OrderDelivered(
                $message->messageDlcf->fulfillingShopCode,
                $message->messageDlcf->identifiers->generalIdentifiers->externalShopOrderNumber,
                Carbon::parse($message->messageDlcf->messageCreateTimestamp),
                Carbon::parse($message->messageDlcf->dateOrderDelivered),
                $message->messageDlcf->identifiers->generalIdentifiers->bmtOrderNumber,
                $message->messageDlcf->signature,
            );
        }


        throw new Exception('Message type not found');
    }
}
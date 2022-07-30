<?php namespace BloomNetwork\Models;

use BloomNetwork\Models\Items\DeliveryDetails;
use BloomNetwork\Models\Items\OrderProductionInfo;
use BloomNetwork\Models\Items\Recipient;
use Carbon\Carbon;

class CreateOrderRequest implements XmlFormatter
{
    protected Carbon $created_at;

    protected OccasionCode $occasion_code;

    protected string $orderCardMessage;

    /** @var OrderProductionInfo[] */
    protected array $productDetails;

    protected float $totalMerchandiseCost;

    protected DeliveryDetails $deliveryDetails;

    protected Recipient $recipient;

    /**
     * @param OrderProductionInfo[] $productDetails
     */
    public function __construct(
        Recipient $recipient,
        array $productDetails,
        DeliveryDetails $deliveryDetails,
        float $totalMerchandiseCost,
        string $orderCardMessage = '',
        OccasionCode $occasionCode = OccasionCode::Funeral_Memorial,
        Carbon $created_at = null,
    ) {
        $this->productDetails       = $productDetails;
        $this->totalMerchandiseCost = $totalMerchandiseCost;
        $this->occasion_code        = $occasionCode;
        $this->created_at           = is_null($created_at) ? Carbon::now() : $created_at;
        $this->orderCardMessage     = $orderCardMessage;
        $this->productDetails       = $productDetails;
        $this->deliveryDetails      = $deliveryDetails;
        $this->recipient            = $recipient;
    }

    public function toXml(): \DOMDocument
    {
        $xml_data = [
            'messagesOnOrder' => [
                'messageCount' => 1,
                'messageOrder' => [
                    'messageType'            => 0,
                    'sendingShopCode'        => '',
                    'receivingShopCode'      => '',
                    'fulfillingShopCode'     => '',
                    'systemType'             => 'GENERAL',
                    'identifiers'            => [
                        'generalIdentifiers' => [
                            'bmtOrderNumber'            => null,
                            'bmtSeqNumberOfOrder'       => null,
                            'bmtSeqNumberOfMessage'     => null,
                            'externalShopOrderNumber'   => 1000, // TODO
                            'externalShopMessageNumber' => null,
                        ],
                    ],
                    'messageCreateTimestamp' => $this->created_at->timestamp,
                    'orderDetails'           => [
                        'orderNumber'            => null,
                        'occasionCode'           => $this->occasion_code->value,
                        'totalCostOfMerchandise' => $this->totalMerchandiseCost,
                        'orderProductsInfo'      => [
                            'orderProductInfoDetails' => array_map(function ($productDetail) {
                                return [
                                    'units'               => $productDetail->units,
                                    'costOfSingleProduct' => $productDetail->costOfSingleProduct,
                                    'productDescription'  => $productDetail->description,
                                ];
                            }, $this->productDetails),
                        ],
                        'orderCardMessage'       => $this->orderCardMessage,
                    ],
                    'orderCaptureDate'       => $this->created_at,
                    'deliveryDetails'        => [
                        'deliveryDate'       => $this->deliveryDetails->deliveryDate->format('m/d/Y'),
                        'specialInstruction' => $this->deliveryDetails->specialInstruction,
                    ],
                    'recipient'              => [
                        'recipientFirstName'   => $this->recipient->firstName,
                        'recipientLastName'    => $this->recipient->lastName,
                        'recipientAttention'   => $this->recipient->attention,
                        'recipientAddress1'    => $this->recipient->address1,
                        'recipientAddress2'    => $this->recipient->address2,
                        'recipientCity'        => $this->recipient->city,
                        'recipientState'       => $this->recipient->state,
                        'recipientZipCode'     => $this->recipient->zip,
                        'recipientCountryCode' => $this->recipient->country,
                        'recipientPhoneNumber' => $this->recipient->phoneNumber,
                    ],
                    'wireServiceCode'        => 'BMT',
                ],
            ],
        ];

        $xml      = new \DOMDocument();

        return $xml;
    }
}
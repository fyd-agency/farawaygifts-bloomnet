<?php namespace BloomNetwork\Models\Items;

class OrderProductionInfo
{
    public function __construct(
        public int $units,
        public float $costOfSingleProduct,
        public string $description,
    ) {
    }
}
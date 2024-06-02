<?php

namespace App\Services\Price\DTO;

class PriceDTO
{
    public function __construct(
        public readonly ?int $buy,
        public readonly ?int $sell,
    ) {}
}

<?php

namespace App\Services\Price;

use App\Services\Fuzzwork\Price\FuzzworkPriceGettingService;
use App\Services\Price\DTO\PriceDTO;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class PriceGettingService
{
    protected int $stationId;
    public function __construct(
        protected FuzzworkPriceGettingService $apiPriceGettingService
    ) {
        $this->stationId = config('eve.default_hub_id');
    }

    /**
     * @return array<PriceDTO>
     */
    public function getPrices(array $typeIds): array
    {
        $prices = [];
        $updateTypeIds = [];

        foreach ($typeIds as $typeId) {
            $key = $this->getCacheKey($typeId);

            if (Cache::has($key)) {
                $prices[$typeId] = Cache::get($key);
            } else {
                $updateTypeIds[] = $typeId;
            }
        }

        if (count($updateTypeIds)) {
            $apiPrices = $this->apiPriceGettingService->getPrices($this->stationId, $updateTypeIds);

            foreach ($apiPrices as $typeId => $price) {
                Cache::set($this->getCacheKey($typeId), $price, 300);
            }

            $prices = array_merge($prices, $apiPrices);
        }

        return Arr::map($prices, function ($price) {
            return new PriceDTO(
                buy: $price['buy']['max'] ?? null,
                sell: $price['sell']['min'] ?? null,
            );
        });
    }

    protected function getCacheKey($typeId)
    {
        return 'type_id_' . $typeId;
    }
}

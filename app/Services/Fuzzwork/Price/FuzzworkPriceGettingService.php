<?php

namespace App\Services\Fuzzwork\Price;

use Illuminate\Support\Facades\Http;

class FuzzworkPriceGettingService
{
    protected string $baseUrl;

    public function __construct() {
        $this->baseUrl = config('fuzzwork.base_url');
    }

    public function getPrices(int $stationId, array $typeIds)
    {
        $query = [
            'station' => $stationId,
            'types' => implode(',', $typeIds),
        ];

        $response = Http::timeout(3)
            ->connectTimeout(3)
            ->throw()
            ->get($this->baseUrl, $query);

        return $response->json();
    }
}

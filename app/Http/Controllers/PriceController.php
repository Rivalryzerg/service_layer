<?php

namespace App\Http\Controllers;

use App\Http\Requests\Price\PriceGettingRequest;
use App\Services\Price\PriceGettingService;

class PriceController extends Controller
{
    public function index(
        PriceGettingRequest $request,
        PriceGettingService $priceGettingService,
    ) {
        $prices = $priceGettingService->getPrices($request->input('type_ids'));

        return response()->json($prices);
    }
}

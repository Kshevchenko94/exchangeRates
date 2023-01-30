<?php

namespace App\Http\Controllers;

use App\Models\{
    Description,
    ExchangeRates,
    Selection
};
use App\Services\ExchangeRates\interfaces\IExchangeRatesService;
use Illuminate\Http\{
    JsonResponse,
    Request
};

class ExchangeRatesController extends Controller
{
    /**
     * @param IExchangeRatesService $exchangeRatesService
     * @param Request $request
     * @return JsonResponse
     */
    public function index(IExchangeRatesService $exchangeRatesService, Request $request): JsonResponse
    {
        return response()->json(
            ExchangeRates::getList(
                $exchangeRatesService,
                $request->query('date_req')
            )
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function save(Request $request): JsonResponse
    {
        $dateReq = ExchangeRates::prepareDate($request->request->get('date_req'));
        $ratesData = $request->request->all('rate');
        $description = $request->request->get('description');
        $rates = ExchangeRates::where('date', '=', $dateReq)
            ->whereIn('char_code', $ratesData)
            ->get();
        if ($rates->isEmpty()) {
            return response()->json(['status' => 'Error', 'text' => 'Rates is not found.'], 404);
        }
        if ($description) {
            $descriptionModel = new Description();
            $descriptionModel->description = $description;
            $descriptionModel->save();
        }
        foreach ($rates as $rate) {
            $selection = new Selection();
            $selection->selection_date = now();
            $selection->exchange_rates_id = $rate->id;
            $selection->description_id = $descriptionModel->id?? null;
            $selection->save();
        }
        return response()->json(['status' => 'OK', 'text' => 'Selection is created.'], 201);
    }

    /**
     * @param string $date
     * @return JsonResponse
     */
    public function view(string $date): JsonResponse
    {
        $selections = Selection::where('selection_date', '=', $date)->get();
        return response()->json($selections);
    }
}

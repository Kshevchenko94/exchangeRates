<?php

namespace App\Models;

use App\Services\ExchangeRates\interfaces\IExchangeRatesService;
use Illuminate\Database\Eloquent\{Collection, Model};
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExchangeRates extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'valute_id',
        'num_code',
        'char_code',
        'nominal',
        'name',
        'value',
        'date',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * @param IExchangeRatesService $exchangeRatesService
     * @param $date
     * @return Collection
     */
    public static function getList(IExchangeRatesService $exchangeRatesService, $date = null): Collection
    {
        $date = $date?? now();

        if (self::isEmptyRecordByDate($date)) {
            $data = $exchangeRatesService->getList($date);
            self::saveExchangeRates($data, $date);
        }
        return self::all()->where('date', '=', self::prepareDate($date));
    }

    /**
     * @param string $date
     * @return string
     */
    public static function prepareDate(string $date): string
    {
        $var = $date;
        $date = str_replace('/', '-', $var);
        return date('Y-m-d', strtotime($date));
    }

    /**
     * @param array $data
     * @param string $date
     * @return void
     */
    public static function saveExchangeRates(array $data, string $date): void
    {
        $data = self::prepareData($data, $date);
        foreach ($data as $item) {
            self::create($item);
        }
    }

    /**
     * @param array $data
     * @param string $date
     * @return array
     */
    private static function prepareData(array $data, string $date): array
    {
        $prepareDate = [];

        foreach ($data['Valute'] as $key => $valute) {
            $prepareDate[$key]['valute_id'] = $valute['@attributes']['ID'];
            $prepareDate[$key]['num_code'] = $valute['NumCode'];
            $prepareDate[$key]['char_code'] = $valute['CharCode'];
            $prepareDate[$key]['nominal'] = $valute['Nominal'];
            $prepareDate[$key]['name'] = $valute['Name'];
            $prepareDate[$key]['value'] = $valute['Value'];
            $prepareDate[$key]['date'] = self::prepareDate($date);

        }
        return $prepareDate;
    }

    /**
     * @param $date
     * @return bool
     */
    public static function isEmptyRecordByDate($date): bool
    {
        return self::all()->where('date', '=', self::prepareDate($date))->isEmpty();
    }
}

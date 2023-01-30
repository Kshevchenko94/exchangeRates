<?php

namespace App\Services\ExchangeRates;

use App\Services\ExchangeRates\interfaces\IExchangeRatesService;
use GuzzleHttp\Client;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;

class ExchangeRatesService implements IExchangeRatesService
{
    private const URL = 'https://www.cbr.ru/scripts/XML_daily.asp';
    private HttpClient $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client();
    }

    /**
     * @param string $date
     * @return array
     *
     * @throws GuzzleException
     */
    public function getList(string $date): array
    {
        $data = $this->httpClient->get(self::URL, ['date_req' => $date]);
        return $this->prepareResponse($data->getBody());
    }

    /**
     * @param $response
     * @return array
     */
    public function prepareResponse($response): array
    {
        $xml = simplexml_load_string($response,'SimpleXMLElement',LIBXML_NOCDATA);
        $json = json_encode($xml);
        return json_decode($json, true);
    }
}

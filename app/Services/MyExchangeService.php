<?php

namespace App\Services;

use Bavix\Wallet\Internal\Service\MathServiceInterface;
use Bavix\Wallet\Services\ExchangeServiceInterface;
use GuzzleHttp\Client;
use Psr\SimpleCache\CacheInterface;

class MyExchangeService implements ExchangeServiceInterface
{
    private array $rates = [];
    private MathServiceInterface $mathService;
    private Client $httpClient;
    private CacheInterface $cache;

    public function __construct(MathServiceInterface $mathService, Client $httpClient, CacheInterface $cache)
    {
        $this->mathService = $mathService;
        $this->httpClient = $httpClient;
        $this->cache = $cache;
    }

    private function loadRatesFromCryptoCompare(string $fromCurrency, string $toCurrency): void
    {
        $cacheKey = "exchange_rate_{$fromCurrency}_to_{$toCurrency}";

        // Attempt to retrieve the rate from the cache
        $cachedRate = $this->cache->get($cacheKey);

        if ($cachedRate === null) {
            // Make an API request to CryptoCompare to get the exchange rate
            $response = $this->httpClient->get("https://min-api.cryptocompare.com/data/price", [
                'query' => [
                    'fsym' => $fromCurrency,
                    'tsyms' => $toCurrency,
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            if (isset($data[$toCurrency])) {
                $rate = $data[$toCurrency];
                $this->rates[$fromCurrency][$toCurrency] = $rate;
                $this->rates[$toCurrency][$fromCurrency] = $this->mathService->div(1, $rate);

                // Cache the rate for 30 minutes
                $this->cache->set($cacheKey, $rate, 1800);
            }
        } else {
            // Use the cached rate
            $this->rates[$fromCurrency][$toCurrency] = $cachedRate;
            $this->rates[$toCurrency][$fromCurrency] = $this->mathService->div(1, $cachedRate);
        }
    }

    /** @param float|int|string $amount */
    public function convertTo(string $fromCurrency, string $toCurrency, $amount): string
    {
        // Ensure rates are loaded for the specified currencies
        if (empty($this->rates[$fromCurrency][$toCurrency])) {
            $this->loadRatesFromCryptoCompare($fromCurrency, $toCurrency);
        }

        return $this->mathService->mul($amount, $this->rates[$fromCurrency][$toCurrency] ?? 1);
    }
}

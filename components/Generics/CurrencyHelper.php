<?php

namespace app\components\Generics;
use Yii;
use yii\base\Component;
use yii\helpers\Json;
use yii\caching\Cache;

class CurrencyHelper extends Component
{
    /**
     * API URL for free forex rates
     * @var string
     */
    private static $apiUrl = 'https://open.er-api.com/v6/latest/';

    /**
     * Cache duration in seconds (1 hour)
     * @var int
     */
    private static $cacheDuration = 3600;

    /**
     * Convert amount from one currency to another
     *
     * @param float $amount Amount to convert
     * @param string $from Source currency code (e.g., 'UGX')
     * @param string $to Target currency code (e.g., 'USD')
     * @return float|null Converted amount or null on failure
     */
    public static function convert($amount, $from = 'UGX', $to = 'USD')
    {
        try {
            $rate = self::getExchangeRate($from, $to);
            if ($rate === null) {
                Yii::error("Failed to get exchange rate from $from to $to", 'currency');
                return null;
            }

            return round($amount * $rate, 2, PHP_ROUND_HALF_DOWN);;
        } catch (\Exception $e) {
            Yii::error('Currency conversion error: ' . $e->getMessage(), 'currency');
            return null;
        }
    }

    /**
     * Get exchange rate between two currencies
     *
     * @param string $from Source currency code
     * @param string $to Target currency code
     * @return float|null Exchange rate or null on failure
     */
    public static function getExchangeRate($from, $to)
    {
        $from = strtoupper($from);
        $to = strtoupper($to);

        // If same currency, return 1
        if ($from === $to) {
            return 1;
        }

        // Try to get rates from cache first
        $cacheKey = "currency_rates_{$from}";
        $rates = Yii::$app->cache->get($cacheKey);

        // If not in cache, fetch from API
        if ($rates === false) {
            $rates = self::fetchRatesFromAPI($from);

            // Cache the rates if successful
            if ($rates !== null) {
                Yii::$app->cache->set($cacheKey, $rates, self::$cacheDuration);
            } else {
                return null;
            }
        }

        // Check if target currency exists in rates
        if (!isset($rates[$to])) {
            Yii::warning("Currency $to not found in exchange rates", 'currency');
            return null;
        }

        return $rates[$to];
    }

    /**
     * Fetch exchange rates from API
     *
     * @param string $baseCurrency Base currency for rates
     * @return array|null Array of exchange rates or null on failure
     */
    private static function fetchRatesFromAPI($baseCurrency)
    {
        try {
            $url = self::$apiUrl . $baseCurrency;

            // Create a new cURL resource
            $ch = curl_init();

            // Set cURL options
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

            // Execute cURL request
            $response = curl_exec($ch);
            $error = curl_error($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            // Close cURL resource
            curl_close($ch);

            // Check for errors
            if (!empty($error) || $httpCode !== 200) {
                Yii::error("API request failed: $error, HTTP Code: $httpCode", 'currency');
                return null;
            }

            // Parse response
            $data = Json::decode($response, true);

            // Check if API returned successfully
            if (!isset($data['rates']) || $data['result'] !== 'success') {
                Yii::error('API returned invalid data: ' . $response, 'currency');
                return null;
            }

            return $data['rates'];
        } catch (\Exception $e) {
            Yii::error('API fetch error: ' . $e->getMessage(), 'currency');
            return null;
        }
    }

    /**
     * Format currency with symbol
     *
     * @param float $amount Amount to format
     * @param string $currency Currency code
     * @return string Formatted amount with currency symbol
     */
    public static function format($amount, $currency = 'USD')
    {
        $symbols = [
            'USD' => '$',
            'UGX' => 'USh',
            'EUR' => '€',
            'GBP' => '£',
            // Add more symbols as needed
        ];

        $symbol = isset($symbols[$currency]) ? $symbols[$currency] : $currency;

        if ($currency === 'UGX') {
            // Format UGX without decimal places
            return $symbol . ' ' . number_format($amount, 0);
        }

        return $symbol . ' ' . number_format($amount, 2);
    }

    /**
     * Get all available exchange rates for a base currency
     *
     * @param string $baseCurrency Base currency code
     * @return array|null Array of all available exchange rates
     */
    public static function getAllRates($baseCurrency = 'USD')
    {
        $baseCurrency = strtoupper($baseCurrency);
        $cacheKey = "currency_rates_{$baseCurrency}";

        $rates = Yii::$app->cache->get($cacheKey);

        if ($rates === false) {
            $rates = self::fetchRatesFromAPI($baseCurrency);

            if ($rates !== null) {
                Yii::$app->cache->set($cacheKey, $rates, self::$cacheDuration);
            }
        }

        return $rates;
    }
}

/**
 * CurrencyHelper provides currency conversion functionality
 *
 * Usage:
 * ```php
 * use app\helpers\CurrencyHelper;
 *
 * // Convert 50000 UGX to USD
 * $usdAmount = CurrencyHelper::convert(50000, 'UGX', 'USD');
 * ```
 */

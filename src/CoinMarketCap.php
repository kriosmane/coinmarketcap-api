<?php

namespace KriosMane\CoinMarketCap;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CoinMarketCap
{
    /**
     * The configuration array for the API.
     * Stores API credentials and other necessary settings.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Constructor to initialize API settings.
     *
     * @param array $config Configuration array containing API credentials and other options.
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * Makes a request to the CoinMarketCap API.
     *
     * @param string $url The API endpoint (relative path).
     * @param array $params The query parameters or body data for the request.
     * @param string $method HTTP method to use ('GET' or 'POST').
     * @return array|null Returns the API response as an associative array, or null on failure.
     */
    public function request(string $url, array $params, string $method = 'GET'): ?array
    {
        // Ensure the base URL is set, fallback to the default CoinMarketCap API base URL
        $baseUrl = rtrim($this->config['api_base_url'] ?? 'https://pro-api.coinmarketcap.com', '/');

        try {
            // Initialize HTTP client with authentication headers
            $response = Http::withHeaders([
                'X-CMC_PRO_API_KEY' => $this->config['api_key'], // API key required for authentication
            ]);

            // Send request based on method type
            if (strtolower($method) === 'get') {
                $response = $response->get($baseUrl . $url, $params);
            } elseif (strtolower($method) === 'post') {
                $response = $response->post($baseUrl . $url, $params);
            }
            
            // Check if the request was successful
            if ($response->successful()) {
                return $response->json(); // Decode and return JSON response
            } else {
                return null; // Return null if the request was unsuccessful
            }
        } catch (\Exception $e) {
            // Log any errors that occur during the request
            Log::error('CoinMarketCap API request failed', [
                'message' => $e->getMessage(),
                'url' => $baseUrl . $url,
                'params' => $params
            ]);

            return null; // Return null in case of an exception
        }
    }

    /**
     * Retrieves the latest cryptocurrency listings.
     * 
     * This endpoint provides a list of the latest cryptocurrencies available on CoinMarketCap, 
     * including their current market data.
     *
     * @param array $params Optional query parameters such as limit, convert currency, etc.
     * @return array|null Returns the response data or null in case of failure.
     */
    public function listCryptos(array $params = []): ?array
    {
        return $this->request('/v1/cryptocurrency/listings/latest', $params);
    }

    /**
     * Retrieves the latest market quote for one or more cryptocurrencies.
     * 
     * This endpoint provides real-time market data for the requested cryptocurrencies, 
     * including price, volume, and market capitalization.
     *
     * @param array $params Query parameters including cryptocurrency symbols or IDs.
     * @return array|null Returns the response data or null in case of failure.
     */
    public function getQuotes(array $params = []): ?array
    {
        return $this->request('/v1/cryptocurrency/quotes/latest', $params);
    }
}

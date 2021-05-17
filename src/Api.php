<?php

namespace KriosMane\CoinMarketCap;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;

class Api {


    /**
     * @var string
     */
    protected $api_key = '';

    /**
     * @var GuzzleHttp\Client
     */
    protected $http_client = null;

    /**
     * @var string
     */
    protected $endpoint = '';

    /**
     * @var boolean
     */
    protected $debug = false;

    /**
     * @var boolean
     */
    protected $verify = false;

    /**
     * 
     */
    public function __construct() {

        $this->_init();

    }

    /**
     * 
     */
    private function _init()
    {
        $this->api_key = config('coinmarketcap.api_key');

        $this->endpoint = config('coinmarketcap.endpoint');

        $this->http_client = new Client([

            'base_uri' => $this->endpoint
        
        ]);
    }

    /**
     * @param string $method
     * @param array $params
     * @param string $type
     * 
     * @return array|boolean
     * 
     */
    public function _call( $method, $params , $type = 'GET')
    {   
        /**
         * 
         */
        $headers = [

            'X-CMC_PRO_API_KEY' => $this->api_key

        ];

        $url = $method.'?'.http_build_query($params);

        try { 

            $request = $this->http_client->request($type, $url, [

                'headers' => $headers,

                'debug'  => $this->debug,

                'verify' => $this->verify
                
            ]);

            return json_decode($request->getBody(), true);

        }catch(ClientException $e) {

            return json_decode($e->getResponse()->getBody(), true);

        } catch(ConnectException $e){
            
        }

    }

    /**
     * Set to true or set to a PHP stream returned by fopen() to enable debug output with the handler used to send a request. 
     * For example, when using cURL to transfer requests, cURL's verbose of CURLOPT_VERBOSE will be emitted. 
     * When using the PHP stream wrapper, stream wrapper notifications will be emitted. 
     * If set to true, the output is written to PHP's STDOUT. 
     * If a PHP stream is provided, output is written to the stream
     * 
     * @param boolean $debug
     * @return void
     */
    public function setDebug($debug)
    {
        $this->debug = $debug;
    }

    /**
     * @return boolean
     */
    public function getDebug()
    {
        return $this->debug;
    }

    /**
     * Describes the SSL certificate verification behavior of a request.
     * 
     * @param boolean $verify
     * @return void
     */
    public function setVerify($verify)
    {
        $this->verify = $verify;
    }

    /**
     * @return boolean
     */
    public function getVerify()
    {
        return $this->verify;
    }

    /**
     * List all cryptocurrencies 
     * Get a paginated list of all cryptocurrencies with latest market data. 
     * You can configure this call to sort by market cap or another market ranking field. 
     * Use the "convert" option to return market values in multiple fiat and cryptocurrency conversions in the same call.
     * Possible parameters are:
     *      name: The cryptocurrency name.
     *      symbol: The cryptocurrency symbol.
     *      date_added: Date cryptocurrency was added to the system.
     *      market_cap: market cap (latest trade price x circulating supply).
     *      price: latest average trade price across markets.
     *      circulating_supply: approximate number of coins currently in circulation.
     *      total_supply: approximate total amount of coins in existence right now (minus any coins that have been verifiably burned).
     *      max_supply: our best approximation of the maximum amount of coins that will ever exist in the lifetime of the currency.
     *      num_market_pairs: number of market pairs across all exchanges trading each currency.
     *      volume_24h: 24 hour trading volume for each currency.
     *      percent_change_1h: 1 hour trading price percentage change for each currency.
     *      percent_change_24h: 24 hour trading price percentage change for each currency.
     *      percent_change_7d: 7 day trading price percentage change for each currency.
     * 
     * @param array $params
     * @return array
     * @deprecated
     */
    public function all_cryptos( $params = [])
    {
        return $this->_call('/v1/cryptocurrency/listings/latest', $params);
    }


    /**
     * List all cryptocurrencies 
     * Get a paginated list of all cryptocurrencies with latest market data. 
     * You can configure this call to sort by market cap or another market ranking field. 
     * Use the "convert" option to return market values in multiple fiat and cryptocurrency conversions in the same call.
     * Possible parameters are:
     *      name: The cryptocurrency name.
     *      symbol: The cryptocurrency symbol.
     *      date_added: Date cryptocurrency was added to the system.
     *      market_cap: market cap (latest trade price x circulating supply).
     *      price: latest average trade price across markets.
     *      circulating_supply: approximate number of coins currently in circulation.
     *      total_supply: approximate total amount of coins in existence right now (minus any coins that have been verifiably burned).
     *      max_supply: our best approximation of the maximum amount of coins that will ever exist in the lifetime of the currency.
     *      num_market_pairs: number of market pairs across all exchanges trading each currency.
     *      volume_24h: 24 hour trading volume for each currency.
     *      percent_change_1h: 1 hour trading price percentage change for each currency.
     *      percent_change_24h: 24 hour trading price percentage change for each currency.
     *      percent_change_7d: 7 day trading price percentage change for each currency.
     * 
     * @param array $params
     * @return array
     */
    public function list( $params = [])
    {
        return $this->_call('/v1/cryptocurrency/listings/latest', $params);
    }


    /**
     * Returns the latest market quote for 1 or more cryptocurrencies. 
     * Use the "convert" option to return market values in multiple fiat and cryptocurrency conversions in the same call.
     * Possible parameters are:
     *      id: One or more comma-separated cryptocurrency CoinMarketCap IDs. Example: 1,2
     *      slug: Alternatively pass a comma-separated list of cryptocurrency slugs. Example: "bitcoin,ethereum"
     *      symbol: Alternatively pass one or more comma-separated cryptocurrency symbols. Example: "BTC,ETH". At least one "id" or "slug" or "symbol" is required for this request.
     *      convert: Optionally calculate market quotes in up to 120 currencies at once by passing a comma-separated list of cryptocurrency or fiat currency symbols. Each additional convert option beyond the first requires an additional call credit. A list of supported fiat options can be found here. Each conversion is returned in its own "quote" object.
     *      convert_id: Optionally calculate market quotes by CoinMarketCap ID instead of symbol. This option is identical to convert outside of ID format. Ex: convert_id=1,2781 would replace convert=BTC,USD in your query. This parameter cannot be used when convert is used.
     *      aux:  Optionally specify a comma-separated list of supplemental data fields to return. Pass num_market_pairs,cmc_rank,date_added,tags,platform,max_supply,circulating_supply,total_supply,market_cap_by_total_supply,volume_24h_reported,volume_7d,volume_7d_reported,volume_30d,volume_30d_reported,is_active,is_fiat to include all auxiliary fields.
     *      skip_invalid: Pass true to relax request validation rules. When requesting records on multiple cryptocurrencies an error is returned if no match is found for 1 or more requested cryptocurrencies. If set to true, invalid lookups will be skipped allowing valid cryptocurrencies to still be returned.
     * 
     * @param array $params
     * @return array
     */
    public function quotes( $params = [] )
    {
        return $this->_call('/v1/cryptocurrency/quotes/latest', $params);
    }

}


?>
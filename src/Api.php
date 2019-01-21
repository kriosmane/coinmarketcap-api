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
     */
    public function all_cryptos( $params = [])
    {
        return $this->_call('/v1/cryptocurrency/listings/latest', $params);
    }

}


?>
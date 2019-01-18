<?php

namespace KriosMane\CoinMarketCap;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;

class Api {


    /**
     * 
     */
    protected $api_key = '';

    /**
     * 
     */
    protected $http_client = null;

    /**
     * 
     */
    protected $endpoint = '';

    /**
     * 
     */
    protected $debug = false;

    /**
     * 
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
     * 
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
     * List all cryptocurrencies 
     * Get a paginated list of all cryptocurrencies with latest market data. 
     * You can configure this call to sort by market cap or another market ranking field. 
     * Use the "convert" option to return market values in multiple fiat and cryptocurrency conversions in the same call.
     */
    public function all_cryptos( $params = [])
    {
        return $this->_call('/v1/cryptocurrency/listings/latest', $params);
    }

}


?>
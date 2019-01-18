# Laravel HiveOS Api
Laravel package for interacting with CoinMarketCap API

## Installation

[PHP](https://php.net) 7.1+ and [Composer](https://getcomposer.org) are required.

To get the latest version simply run the code below in your project.

```
composer require krios-mane/coinmarketcap-api
```
Once is installed you need to register the service provider. Open up `config/app.php` and add the following to the `providers` key.

```php
'providers' => [
    ...
    KriosMane\CoinMarketCap\Providers\CoinMarketCapServiceProvider::class,
    ...
]
```

Also, register the Facade like so:

```php
'aliases' => [
    ...
    'CoinMarketCapApi' => KriosMane\CoinMarketCap\Facades\CoinMarketCap::class 
    ...
]
```

## Configuration

You can publish the configuration file using this command:

```bash
php artisan vendor:publish --provider="KriosMane\CoinMarketCap\Providers\CoinMarketCapServiceProvider"
```

A configuration-file named `coinmarketcap.php` with default settings will be placed in your `config` directory:

You can visit this link to get your CoinMarketCap API key

```
https://pro.coinmarketcap.com/login/
```

## Usage

Open your .env file and add the following in this format. Ensure you must have gotten your api key:

```php
CMC_API_KEY=********-****-****-****-**********
```

Add the following line to your controller

```php
use \CoinMarketCapApi;


return CoinMarketCapApi::all_cryptos();


```

## Contributing

Please feel free to fork this package and contribute by submitting a pull request to enhance the functionalities.

## How can I thank you?

Why not star the github repo? I'd love the attention! Why not share the link for this repository on Twitter or HackerNews? Spread the word!


Thanks!
Krios Mane

## License

Please see [License File](LICENSE.md) for more information.


# Laravel CoinMarketCap API

[![Latest Version on Packagist](https://img.shields.io/packagist/v/kriosmane/coinmarketcap-api.svg?style=flat-square)](https://packagist.org/packages/kriosmane/coinmarketcap-api)
[![Total Downloads](https://img.shields.io/packagist/dt/kriosmane/coinmarketcap-api.svg?style=flat-square)](https://packagist.org/packages/kriosmane/coinmarketcap-api)

A Laravel package for interacting with the CoinMarketCap API.

## 🚀 Installation

Laravel 11 requires **PHP 8.1+** and **Composer**.

To install the latest version, run:

```bash
composer require kriosmane/coinmarketcap-api
```

### 📌 Service Provider & Facade (Not Required for Laravel 11)

From Laravel 11, service providers and facades are auto-discovered. However, if you need to register them manually, add the following to your `config/app.php` file:

#### Service Provider (Only if required)
```php
'providers' => [
    KriosMane\CoinMarketCap\Providers\CoinMarketCapServiceProvider::class,
],
```

#### Facade (Only if required)
```php
'aliases' => [
    'CoinMarketCapApi' => KriosMane\CoinMarketCap\Facades\CoinMarketCap::class,
],
```

## ⚙️ Configuration

Publish the configuration file using:

```bash
php artisan vendor:publish --provider="KriosMane\CoinMarketCap\Providers\CoinMarketCapServiceProvider"
```

This will create a `coinmarketcap.php` file in your `config` directory.

Get your **CoinMarketCap API Key** from:

🔗 [CoinMarketCap API](https://pro.coinmarketcap.com/login/)

Then, add the key to your `.env` file:

```env
CMC_API_KEY=your-api-key-here
```

## 📖 Usage

You can start using the API in your controllers or services:

```php
use CoinMarketCap;

// Get latest cryptocurrency listings
$cryptos = CoinMarketCap::listCryptos();

// Get latest market quotes for a specific cryptocurrency
$quotes = CoinMarketCap::getQuotes(['symbol' => 'BTC,ETH']);
```

## 🤝 Contributing

Feel free to fork this repository and submit a pull request to enhance its functionality.

## ☕ How can I thank you?

If you found this package helpful, consider buying me a coffee!  
[☕ Buy me a coffee](https://www.buymeacoffee.com/kriosmane)  

⭐ Star the repo, share it on Twitter, or post about it on HackerNews. Spread the word!

Thank you!  
**Krios Mane**

## 📜 License

Please see [License File](LICENSE.md) for more information.


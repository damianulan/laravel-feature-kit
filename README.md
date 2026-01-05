# Laravel FeatureKit

[![Static Badge](https://img.shields.io/badge/made_with-Laravel-red?style=for-the-badge)](https://laravel.com/docs/11.x/releases) &nbsp; [![Licence](https://img.shields.io/github/license/Ileriayo/markdown-badges?style=for-the-badge)](./LICENSE) &nbsp; [![Static Badge](https://img.shields.io/badge/maintainer-damianulan-blue?style=for-the-badge)](https://damianulan.me)

### Description


## Getting Started

### Installation

You can install the package via composer in your laravel project:

```
composer require damianulan/laravel-feature-kit
```
The package will automatically register itself.
Next step is to publish necessary vendor assets.

```
// if you need both migration and config
php artisan vendor:publish --tag=featurekit

// if you need only config and use json storage
php artisan vendor:publish --tag=featurekit-config

```

### Registering Features

Features are autodiscovered when placed in `*/Features` directory, but you can also register them manually in your config file.
```php
// config/featurekit.php
'features' => [
    'App\Features\MyFeature',
],
```
Feature information is stored in a database table, but you can also use json storage.
```php
// config/featurekit.php
'connection' => env('FEATUREKIT_CONNECTION', 'database') // json,
```

### Usage

### Examples

### Contact & Contributing

Any question You can submit to **damian.ulan@protonmail.com**.

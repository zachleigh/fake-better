# Fake Better
Because Lorem Ipsum sucks sometimes.

## Contents
  - [About](#about)
  - [Install](#install)
  - [Usage](#usage)
  - [Laravel Support](#laravel-support)
  - [Contributing](#contributing)

## About
This package lets you define real copy to use in Faker instead Lorem Ipsum. You only
need to add the included Copy Faker provider to Faker.

## Install
This pacakge requires [Faker](https://github.com/fzaninotto/Faker).   

Install via composer:
```php
composer require zachleigh/fake-better
```

**If using Laravel, see the [Laravel Support section](#laravel-support).**   

Once installed, you need to add the `FakeBetter\Providers\Copy` provider to your
Faker instance:
```php
use Faker\Generator;
use FakeBetter\Providers\Copy;

$faker = new Generator();

$copyProvider = new Copy($faker);

$copyProvider->setCopyPath('path/to/copy/directory');

$faker->addProvider($copyProvider);
```

## Usage
In the set copy path, define any file structure you like. All files must be php files
and should return an array. To access the copy use the `copy::get` method:
```php
$faker->copy->get('path.to.copy');
```

## Laravel Support
If using Laravel, register the service provider:
```php
FakeBetter\Laravel\ServiceProvider::class
```

Override the default paths by importing the config:
```php
php artisan vendor:publish --provider="FakeBetter\Laravel\ServiceProvider" --tag="config"
```

Create new copy files:
```php
php artisan make:faker-copy
```

In addition to the Copy provider, this package also allows you to easily create
custom Faker providers:
```php
php artisan make:faker-provider CustomProvider
```

## Contributing
Contributions are more than welcome. Fork, improve and make a pull request.    

For bugs, ideas for improvement or other, please create an [issue](https://github.com/zachleigh/laravel-property-bag/issues).

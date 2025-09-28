# This is my package hebrew-date-picker

[![Latest Version on Packagist](https://img.shields.io/packagist/v/eli-sheinfeld/hebrew-date-picker.svg?style=flat-square)](https://packagist.org/packages/eli-sheinfeld/hebrew-date-picker)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/eli-sheinfeld/hebrew-date-picker/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/eli-sheinfeld/hebrew-date-picker/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/eli-sheinfeld/hebrew-date-picker/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/eli-sheinfeld/hebrew-date-picker/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/eli-sheinfeld/hebrew-date-picker.svg?style=flat-square)](https://packagist.org/packages/eli-sheinfeld/hebrew-date-picker)



This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require eli-sheinfeld/hebrew-date-picker
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="hebrew-date-picker-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="hebrew-date-picker-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="hebrew-date-picker-views"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$hebrewDatePicker = new Eli Sheinfeld\HebrewDatePicker();
echo $hebrewDatePicker->echoPhrase('Hello, Eli Sheinfeld!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Eli](https://github.com/Eli sheinfeld)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

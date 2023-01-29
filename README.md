# Spatie Image Optimizer Health Check

[![Latest Version on Packagist](https://img.shields.io/packagist/v/lloricode/spatie-image-optimizer-health-check.svg?style=flat-square)](https://packagist.org/packages/lloricode/spatie-image-optimizer-health-check)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/lloricode/spatie-image-optimizer-health-check/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/lloricode/spatie-image-optimizer-health-check/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/lloricode/spatie-image-optimizer-health-check/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/lloricode/spatie-image-optimizer-health-check/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/lloricode/spatie-image-optimizer-health-check.svg?style=flat-square)](https://packagist.org/packages/lloricode/spatie-image-optimizer-health-check)

When using [laravel-medialibrary](https://github.com/spatie/laravel-medialibrary) it uses [image-optimizer](https://github.com/spatie/image-optimizer) under the hood, and probably this would not work if optimizer tools is not installed on you server.
These checks are where you can check if optimizer is installed on your server.

## Installation

You can install the package via composer:

```bash
composer require lloricode/spatie-image-optimizer-health-check
```

## Usage

```php
use Lloricode\SpatieImageOptimizerHealthCheck\ImageOptimizerCheck;
use Spatie\Health\Facades\Health;

# all optimizer
Health::checks([
    ImageOptimizerCheck::new(),
]);

# specific optimizer
Health::checks([
    ImageOptimizerCheck::new()
        ->checkJPEGOPTIM()
        ->checkOPTIPNG()
        ->checkPNGQUANT()
        ->checkSVGO()
        ->checkGIFSICLE()
        ->checkWEBP(),
]);
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Lloric Mayuga Garcia](https://github.com/lloricode)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

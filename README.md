# Laravel database log channel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/goszowski/laravel-database-log-channel.svg?style=flat-square)](https://packagist.org/packages/goszowski/laravel-database-log-channel)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/goszowski/laravel-database-log-channel/Check%20&%20fix%20styling?label=code%20style)](https://github.com/goszowski/laravel-database-log-channel/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/goszowski/laravel-database-log-channel.svg?style=flat-square)](https://packagist.org/packages/goszowski/laravel-database-log-channel)


The package provides the ability to write logs into the database synchronously or asynchronously, along with other logging channels.

## Installation

You can install the package via composer:

```bash
composer require goszowski/laravel-database-log-channel
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="database-log-channel-migrations"
php artisan migrate
```

Configure logging.php:

```php
return [
    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['daily', 'database'], // Add "database" channel
            'ignore_exceptions' => false,
        ],

        // ...
        'database' => [
            'driver' => 'monolog',
            'handler' => Goszowski\DatabaseLogChannel\Logging\DatabaseLogHandler::class,
            'via' => Goszowski\DatabaseLogChannel\Logging\DatabaseLogger::class,

            'alternative-log-channel' => 'daily', // Use an alternate channel when it is not possible to write to the database
            'connection' => null, // Use default connection
            'table' => 'logs',
            'async' => true, // If true, will be sent to the queue
            'queue' => 'default', // Define a queue for asynchronous logging
            'level' => 'error',
        ],

    ],
];
```

## Usage

```php
use Log;

Log::error('My error message');
```
## Data Pruning

Without pruning, the logs table can accumulate records very quickly. To mitigate this, you should schedule the database-logs:prune Artisan command to run daily:

```php
$schedule->command('database-logs:prune')->daily();
```

By default, all entries older than 24 hours will be pruned. You may use the hours option when calling the command to determine how long to retain Logs data. For example, the following command will delete all records created over 48 hours ago:

```php
$schedule->command('database-logs:prune --hours=48')->daily();
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [goszowski](https://github.com/goszowski)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

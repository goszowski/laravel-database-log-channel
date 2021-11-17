<?php

namespace Goszowski\DatabaseLogChannel;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Goszowski\DatabaseLogChannel\Commands\DatabaseLogsPruneCommand;

class DatabaseLogChannelServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-database-log-channel')
            ->hasMigration('create_logs_table')
            ->hasCommand(DatabaseLogsPruneCommand::class);
    }
}

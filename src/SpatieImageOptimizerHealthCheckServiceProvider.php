<?php

declare(strict_types=1);

namespace Lloricode\SpatieImageOptimizerHealthCheck;

use Lloricode\SpatieImageOptimizerHealthCheck\Commands\SpatieImageOptimizerHealthCheckCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SpatieImageOptimizerHealthCheckServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('spatie-image-optimizer-health-check')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_spatie-image-optimizer-health-check_table')
            ->hasCommand(SpatieImageOptimizerHealthCheckCommand::class);
    }
}

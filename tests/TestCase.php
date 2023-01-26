<?php

declare(strict_types=1);

namespace Lloricode\SpatieImageOptimizerHealthCheck\Tests;

use Lloricode\SpatieImageOptimizerHealthCheck\SpatieImageOptimizerHealthCheckServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            SpatieImageOptimizerHealthCheckServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_spatie-image-optimizer-health-check_table.php.stub';
        $migration->up();
        */
    }
}

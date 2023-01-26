<?php

declare(strict_types=1);

namespace Lloricode\SpatieImageOptimizerHealthCheck\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Lloricode\SpatieImageOptimizerHealthCheck\SpatieImageOptimizerHealthCheck
 */
class SpatieImageOptimizerHealthCheck extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Lloricode\SpatieImageOptimizerHealthCheck\SpatieImageOptimizerHealthCheck::class;
    }
}

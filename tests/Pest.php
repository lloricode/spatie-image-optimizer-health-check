<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Process;
use Lloricode\SpatieImageOptimizerHealthCheck\Tests\TestCase;

uses(TestCase::class)
    ->in(__DIR__)
    ->beforeEach(function () {
        Process::preventStrayProcesses();
    });

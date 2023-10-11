<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Process;
use Lloricode\SpatieImageOptimizerHealthCheck\Optimizer;

function fakeSuccessAllCommand(): void
{
    Process::fake(
        [
            Optimizer::JPEGOPTIM->command() => Process::result(
                output: 'jpegoptim v1.4.6  ..',
            ),

            Optimizer::OPTIPNG->command() => Process::result(
                output: 'OptiPNG version 0.7.7 ..'
            ),

            Optimizer::SVGO->command() => Process::result(
                output: '????'
            ),

            Optimizer::GIFSICLE->command() => Process::result(
                output: 'LCDF Gifsicle 1.92 ...'
            ),

            Optimizer::WEBP->command() => Process::result(
                output: 'Usage: ...'
            ),

            Optimizer::PNGQUANT->command() => Process::result(
                output: '2.12.0 (January 2018) ..'
            ),
        ]
    );
}

function fakeFailedAllCommand(): void
{
    Process::fake(
        [
            Optimizer::JPEGOPTIM->command() => Process::result(
                output: 'jpegoptim v1.4.6  ..',
                errorOutput: 'test error',
                exitCode: 1,
            ),

            Optimizer::OPTIPNG->command() => Process::result(
                output: 'OptiPNG version 0.7.7 ..',
                errorOutput: 'test error',
                exitCode: 1,
            ),

            Optimizer::SVGO->command() => Process::result(
                output: '????',
                errorOutput: 'test error',
                exitCode: 1,
            ),

            Optimizer::GIFSICLE->command() => Process::result(
                output: 'LCDF Gifsicle 1.92 ...',
                errorOutput: 'test error',
                exitCode: 1,
            ),

            Optimizer::WEBP->command() => Process::result(
                output: 'Usage: ...',
                errorOutput: 'test error',
                exitCode: 1,
            ),

            Optimizer::PNGQUANT->command() => Process::result(
                output: '2.12.0 (January 2018) ..',
                errorOutput: 'test error',
                exitCode: 1,
            ),
        ]
    );
}

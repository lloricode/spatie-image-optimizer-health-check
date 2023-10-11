<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Process;
use Lloricode\SpatieImageOptimizerHealthCheck\Optimizer;

function fakeAllCommand(): void
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

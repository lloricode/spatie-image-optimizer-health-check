<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Process;
use Lloricode\SpatieImageOptimizerHealthCheck\Optimizer;

function fakeSuccessAllCommand(): void
{
    Process::fake(
        [
            toStringCommand(Optimizer::JPEGOPTIM) => Process::result(
                output: 'jpegoptim v1.4.6  ..',
            ),

            toStringCommand(Optimizer::OPTIPNG) => Process::result(
                output: 'OptiPNG version 0.7.7 ..'
            ),

            toStringCommand(Optimizer::SVGO) => Process::result(
                output: '????'
            ),

            toStringCommand(Optimizer::GIFSICLE) => Process::result(
                output: 'LCDF Gifsicle 1.92 ...'
            ),

            toStringCommand(Optimizer::WEBP) => Process::result(
                output: 'Usage: ...'
            ),

            toStringCommand(Optimizer::PNGQUANT) => Process::result(
                output: '2.12.0 (January 2018) ..'
            ),

            toStringCommand(Optimizer::AVIFENC) => Process::result(
                output: '????'
            ),
        ]
    );
}

function fakeFailedAllCommand(): void
{
    Process::fake(
        [
            toStringCommand(Optimizer::JPEGOPTIM) => Process::result(
                output: 'jpegoptim v1.4.6  ..',
                errorOutput: 'test error',
                exitCode: 1,
            ),

            toStringCommand(Optimizer::OPTIPNG) => Process::result(
                output: 'OptiPNG version 0.7.7 ..',
                errorOutput: 'test error',
                exitCode: 1,
            ),

            toStringCommand(Optimizer::SVGO) => Process::result(
                output: '????',
                errorOutput: 'test error',
                exitCode: 1,
            ),

            toStringCommand(Optimizer::GIFSICLE) => Process::result(
                output: 'LCDF Gifsicle 1.92 ...',
                errorOutput: 'test error',
                exitCode: 1,
            ),

            toStringCommand(Optimizer::WEBP) => Process::result(
                output: 'Usage: ...',
                errorOutput: 'test error',
                exitCode: 1,
            ),

            toStringCommand(Optimizer::PNGQUANT) => Process::result(
                output: '2.12.0 (January 2018) ..',
                errorOutput: 'test error',
                exitCode: 1,
            ),

            toStringCommand(Optimizer::AVIFENC) => Process::result(
                output: '????',
                errorOutput: 'test error',
                exitCode: 1,
            ),
        ]
    );
}

function toStringCommand(Optimizer $command): string
{
    return implode(
        ' ',
        array_map(
            fn (string $argument) => "'{$argument}'",
            $command->command(),
        )
    );
}

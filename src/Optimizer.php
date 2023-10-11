<?php

declare(strict_types=1);

namespace Lloricode\SpatieImageOptimizerHealthCheck;

use Illuminate\Support\Facades\Process;

enum Optimizer: string
{
    case JPEGOPTIM = 'jpegoptim';
    case OPTIPNG = 'optipng';
    case PNGQUANT = 'pngquant';
    case SVGO = 'svgo';
    case GIFSICLE = 'gifsicle';
    case WEBP = 'cwebp';

    public function command(): string
    {
        return match ($this) {
            self::WEBP => $this->value,
            default => $this->value.' --version',
        };
    }

    public function check(int $timeout = 60): CheckResult
    {
        $process = Process::timeout($timeout)->run($this->command());

        if ($process->successful()) {
            return new CheckResult(true, $process->output());
        }

        return new CheckResult(false, $process->errorOutput());
    }
}

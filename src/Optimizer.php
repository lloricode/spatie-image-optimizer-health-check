<?php

declare(strict_types=1);

namespace Lloricode\SpatieImageOptimizerHealthCheck;

use Illuminate\Support\Facades\Process;
use Spatie\Enum\Enum;

/**
 * @method static self JPEGOPTIM()
 * @method static self OPTIPNG()
 * @method static self PNGQUANT()
 * @method static self SVGO()
 * @method static self GIFSICLE()
 * @method static self WEBP()
 */
class Optimizer extends Enum
{
    protected static function values(): array
    {
        return [
            'JPEGOPTIM' => 'jpegoptim',
            'OPTIPNG' => 'optipng',
            'PNGQUANT' => 'pngquant',
            'SVGO' => 'svgo',
            'GIFSICLE' => 'gifsicle',
            'WEBP' => 'cwebp',
        ];
    }

    public function command(): string
    {
        return match ($this) {
            self::WEBP() => $this->value,
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

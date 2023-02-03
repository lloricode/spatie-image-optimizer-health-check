<?php

declare(strict_types=1);

namespace Lloricode\SpatieImageOptimizerHealthCheck;

use Spatie\Enum\Enum;
use Symfony\Component\Process\Process;

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

    protected function command(): string
    {
        return match ($this) {
            self::WEBP() => $this->value,
            default => $this->value.' --version',
        };
    }

    public function check(int $timeout = 60): CheckResult
    {
        $process = Process::fromShellCommandline($this->command());

        $process
            ->setTimeout($timeout)
            ->run();

        if ($process->isSuccessful()) {
            return new CheckResult(true, $process->getOutput());
        }

        return new CheckResult(false, $process->getErrorOutput());
    }
}

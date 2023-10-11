<?php

declare(strict_types=1);

namespace Lloricode\SpatieImageOptimizerHealthCheck;

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
}

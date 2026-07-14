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
    case AVIFENC = 'avifenc';

    /** @return list<non-empty-string> */
    public function command(): array
    {
        return match ($this) {
            self::WEBP => [$this->value, '-version'],
            default => [$this->value, '--version'],
        };
    }
}

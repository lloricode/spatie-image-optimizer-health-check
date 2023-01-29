<?php

declare(strict_types=1);

namespace Lloricode\SpatieImageOptimizerHealthCheck;

class CheckResult
{
    public function __construct(
        public bool $success,
        public string $message
    ) {
    }
}

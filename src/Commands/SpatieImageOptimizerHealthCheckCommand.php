<?php

declare(strict_types=1);

namespace Lloricode\SpatieImageOptimizerHealthCheck\Commands;

use Illuminate\Console\Command;

class SpatieImageOptimizerHealthCheckCommand extends Command
{
    public $signature = 'spatie-image-optimizer-health-check';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}

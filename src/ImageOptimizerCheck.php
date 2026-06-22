<?php

declare(strict_types=1);

namespace Lloricode\SpatieImageOptimizerHealthCheck;

use Illuminate\Support\Facades\Process;
use Spatie\Health\Checks\Check;
use Spatie\Health\Checks\Result;

class ImageOptimizerCheck extends Check
{
    /**
     * @var array<int, Optimizer>|null
     */
    private ?array $checks = null;

    private int $timeout = 60;

    public function timeout(int $timeout): self
    {
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * @param  array<int, Optimizer>|Optimizer  $optimizers
     */
    public function addChecks(array|Optimizer $optimizers): self
    {
        foreach (is_array($optimizers) ? $optimizers : [$optimizers] as $optimizer) {
            if (! in_array($optimizer, $this->checks ?? [], true)) {
                $this->checks[] = $optimizer;
            }
        }

        return $this;
    }

    public function run(): Result
    {
        $result = Result::make();

        /** @var list<string> $ok */
        $ok = [];

        /** @var list<string> $ok */
        $failed = [];

        foreach (Optimizer::cases() as $optimizer) {
            if (! $this->shouldPerformCheck($optimizer)) {
                continue;
            }

            $process = Process::timeout($this->timeout)
                ->run($optimizer->command());

            if ($process->successful()) {
                $ok[] = $optimizer->value;

            } else {
                $failed[] = $optimizer->value;
            }
        }

        $okSummary = self::formatSummary('OK', $ok);

        if (blank($failed)) {
            return $result->ok()->shortSummary($okSummary);
        }

        $failedSummary = self::formatSummary('FAILED', $failed);

        $result->shortSummary("{$okSummary} | {$failedSummary}");

        return $result->failed("{$okSummary} | {$failedSummary}");
    }

    private function shouldPerformCheck(Optimizer $optimizer): bool
    {
        if ($this->checks === null) {
            return true;
        }

        return in_array($optimizer, $this->checks, true);
    }

    /**
     * @param  list<string>  $optimizers
     */
    private static function formatSummary(string $label, array $optimizers): string
    {
        $summary = blank($optimizers) ? 'none' : implode(', ', $optimizers);

        return "{$label}: {$summary}";
    }
}

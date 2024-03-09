<?php

declare(strict_types=1);

namespace Lloricode\SpatieImageOptimizerHealthCheck;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Process;
use Spatie\Health\Checks\Check;
use Spatie\Health\Checks\Result;

class ImageOptimizerCheck extends Check
{
    /**
     * @var array<int, \Lloricode\SpatieImageOptimizerHealthCheck\Optimizer>|null
     */
    private ?array $checks = null;

    private int $timeout = 60;

    public function timeout(int $timeout): self
    {
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * @param  \Lloricode\SpatieImageOptimizerHealthCheck\Optimizer|array<int, \Lloricode\SpatieImageOptimizerHealthCheck\Optimizer>  $optimizers
     */
    public function addChecks(array|Optimizer $optimizers): self
    {
        foreach (Arr::wrap($optimizers) as $optimizer) {
            if (! in_array($optimizer, $this->checks ?? [])) {
                $this->checks[] = $optimizer;
            }
        }

        return $this;
    }

    public function run(): Result
    {
        $result = Result::make()->ok();

        collect(Optimizer::cases())
            ->each(
                function (Optimizer $optimizer) use (&$result): bool {

                    if (! $this->shouldPerformCheck($optimizer)) {
                        return true;
                    }

                    $checkResult = $this->check($optimizer);

                    if ($checkResult !== true) {
                        $result = $checkResult;

                        return false;
                    }

                    return true;
                }
            );

        return $result;
    }

    private function check(Optimizer $optimizer): Result|true
    {
        $process = Process::timeout($this->timeout)
            ->run($optimizer->command());

        if ($process->successful()) {
            return true;
        }

        return Result::make()->failed($process->errorOutput());
    }

    private function shouldPerformCheck(Optimizer $optimizer): bool
    {
        if ($this->checks === null) {
            return true;
        }

        return in_array($optimizer, $this->checks);
    }

    /** @deprecated use addChecks() will be removed on v3 */
    public function checkJPEGOPTIM(): self
    {
        return $this->addChecks(Optimizer::JPEGOPTIM);
    }

    /** @deprecated use addChecks() will be removed on v3 */
    public function checkOPTIPNG(): self
    {
        return $this->addChecks(Optimizer::OPTIPNG);
    }

    /** @deprecated use addChecks() will be removed on v3 */
    public function checkPNGQUANT(): self
    {
        return $this->addChecks(Optimizer::PNGQUANT);
    }

    /** @deprecated use addChecks() will be removed on v3 */
    public function checkSVGO(): self
    {
        return $this->addChecks(Optimizer::SVGO);
    }

    /** @deprecated use addChecks() will be removed on v3 */
    public function checkGIFSICLE(): self
    {
        return $this->addChecks(Optimizer::GIFSICLE);
    }

    /** @deprecated use addChecks() will be removed on v3 */
    public function checkWEBP(): self
    {
        return $this->addChecks(Optimizer::WEBP);
    }
}

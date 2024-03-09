<?php

declare(strict_types=1);

namespace Lloricode\SpatieImageOptimizerHealthCheck;

use Illuminate\Support\Facades\Process;
use Spatie\Health\Checks\Check;
use Spatie\Health\Checks\Result;

class ImageOptimizerCheck extends Check
{
    private ?array $checks = null;

    private int $timeout = 60;

    public function timeout(int $timeout): self
    {
        $this->timeout = $timeout;

        return $this;
    }

    public function addCheck(Optimizer $optimizer): self
    {
        if (! in_array($optimizer, $this->checks ?? [])) {
            $this->checks[] = $optimizer;
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

    /** @deprecated use addCheck() will be removed on v3 */
    public function checkJPEGOPTIM(): self
    {
        return $this->addCheck(Optimizer::JPEGOPTIM);
    }

    /** @deprecated use addCheck() will be removed on v3 */
    public function checkOPTIPNG(): self
    {
        return $this->addCheck(Optimizer::OPTIPNG);
    }

    /** @deprecated use addCheck() will be removed on v3 */
    public function checkPNGQUANT(): self
    {
        return $this->addCheck(Optimizer::PNGQUANT);
    }

    /** @deprecated use addCheck() will be removed on v3 */
    public function checkSVGO(): self
    {
        return $this->addCheck(Optimizer::SVGO);
    }

    /** @deprecated use addCheck() will be removed on v3 */
    public function checkGIFSICLE(): self
    {
        return $this->addCheck(Optimizer::GIFSICLE);
    }

    /** @deprecated use addCheck() will be removed on v3 */
    public function checkWEBP(): self
    {
        return $this->addCheck(Optimizer::WEBP);
    }
}

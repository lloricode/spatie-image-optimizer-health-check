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

    private function addCheck(Optimizer $optimizer): self
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
                function (Optimizer $optimizer) use (&$result) {

                    if ($this->shouldPerformCheck($optimizer)) {

                        $checkResult = $this->check($optimizer);

                        // phpstan error: Method Lloricode\SpatieImageOptimizerHealthCheck\ImageOptimizerCheck::run() should return Spatie\Health\Checks\Result but returns Spatie\Health\Checks\Result|false.
                        if (! is_bool($checkResult)) {

                            $result = $checkResult;

                            return false;
                        }
                    }

                    return true;
                }
            );

        return $result;
    }

    private function check(Optimizer $optimizer): Result|bool // TODO: remove `bool` then use `true` on php 8.2
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
            //            ray($optimizer)->green();
            return true;
        }
        //        ray($optimizer)->orange();

        return in_array($optimizer, $this->checks);
    }

    public function checkJPEGOPTIM(): self
    {
        return $this->addCheck(Optimizer::JPEGOPTIM);
    }

    public function checkOPTIPNG(): self
    {
        return $this->addCheck(Optimizer::OPTIPNG);
    }

    public function checkPNGQUANT(): self
    {
        return $this->addCheck(Optimizer::PNGQUANT);
    }

    public function checkSVGO(): self
    {
        return $this->addCheck(Optimizer::SVGO);
    }

    public function checkGIFSICLE(): self
    {
        return $this->addCheck(Optimizer::GIFSICLE);
    }

    public function checkWEBP(): self
    {
        return $this->addCheck(Optimizer::WEBP);
    }
}

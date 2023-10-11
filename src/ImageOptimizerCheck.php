<?php

declare(strict_types=1);

namespace Lloricode\SpatieImageOptimizerHealthCheck;

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
                function (Optimizer $optimizer) use (&$result) {
                    if ($this->shouldPerformCheck($optimizer)) {
                        $checkResult = $optimizer->check($this->timeout);
                        if (! $checkResult->success) {

                            $result = Result::make()->failed($checkResult->message);

                            return false;
                        }
                    }

                    return true;
                }
            );

        return $result;
    }

    protected function shouldPerformCheck(Optimizer $optimizer): bool
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

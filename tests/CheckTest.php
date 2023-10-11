<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Process;
use Lloricode\SpatieImageOptimizerHealthCheck\ImageOptimizerCheck;
use Lloricode\SpatieImageOptimizerHealthCheck\Optimizer;
use Spatie\Health\Enums\Status;

it('all check ok w/o output', function () {

    Process::fake();

    $result = (new ImageOptimizerCheck())->run();

    expect($result->status)
        ->toBe(checkOk(), $result->notificationMessage);

});

it('all check ok w/ output', function () {

    fakeAllCommand();

    $result = (new ImageOptimizerCheck())->run();

    expect($result->status)
        ->toBe(checkOk(), $result->notificationMessage);

});

it('failed check w/ one error', function (Optimizer $optimizer) {

    fakeAllCommand();

    Process::fake([
        $optimizer->command() => Process::result(
            output: 'test output',
            errorOutput: 'test error',
            exitCode: 1
        ),
    ]);

    $result = (new ImageOptimizerCheck())->run();

    expect($result->status)
        ->toBe(checkFailed(), $result->notificationMessage);

})
    ->with(fn () => Optimizer::cases());

function checkOk(): Status
{
    return Status::ok();
}

function checkFailed(): Status
{
    return Status::failed();
}

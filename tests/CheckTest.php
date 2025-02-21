<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Process;
use Lloricode\SpatieImageOptimizerHealthCheck\ImageOptimizerCheck;
use Lloricode\SpatieImageOptimizerHealthCheck\Optimizer;
use Spatie\Health\Enums\Status;

it('all check ok w/o output', function () {

    Process::fake();

    $result = (new ImageOptimizerCheck)->run();

    expect($result->status)
        ->toBe(checkOk(), $result->notificationMessage);

});

it('all check ok w/ output', function () {

    fakeSuccessAllCommand();

    $result = (new ImageOptimizerCheck)->run();

    expect($result->status)
        ->toBe(checkOk(), $result->notificationMessage);

});

it('failed check w/ only one error', function (Optimizer $optimizer) {

    fakeSuccessAllCommand();

    Process::fake([
        $optimizer->command() => Process::result(
            output: 'test output',
            errorOutput: 'test error',
            exitCode: 1
        ),
    ]);

    $result = (new ImageOptimizerCheck)->run();

    expect($result->status)
        ->toBe(checkFailed(), $result->notificationMessage);

})
    ->with(fn () => Optimizer::cases());

it('passed check w/ only one checks', function (Optimizer $optimizer) {

    fakeFailedAllCommand();

    Process::fake([
        $optimizer->command() => Process::result(
            output: 'test output',
        ),
    ]);

    $result = (new ImageOptimizerCheck)
        ->addChecks($optimizer)
        ->run();

    expect($result->status)
        ->toBe(checkOk(), $result->notificationMessage);

})
    ->with(fn () => Optimizer::cases());

it('use timeout', function () {

    Process::fake();

    $result = (new ImageOptimizerCheck)
        ->timeout(fake()->numberBetween(100, 200))
        ->run();

    expect($result->status)
        ->toBe(checkOk(), $result->notificationMessage);

});

function checkOk(): Status
{
    return Status::ok();
}

function checkFailed(): Status
{
    return Status::failed();
}

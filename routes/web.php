<?php

declare(strict_types=1);

use Gboquizo\PhpstanReport\Http\ChangeLevelController;
use Gboquizo\PhpstanReport\Http\IndexReportController;
use Gboquizo\PhpstanReport\Http\ProcessCommandController;
use Illuminate\Support\Facades\Route;

Route::middleware('web')
    ->prefix('phpstan-report')
    ->group(static function (): void {
        Route::get('/', IndexReportController::class);
        Route::post('run', ProcessCommandController::class);
        Route::post('change-level', ChangeLevelController::class);
    });

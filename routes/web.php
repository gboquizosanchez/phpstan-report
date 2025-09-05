<?php

declare(strict_types=1);

use Boquizo\PhpstanReport\Http\ChangeLevelController;
use Boquizo\PhpstanReport\Http\IndexReportController;
use Boquizo\PhpstanReport\Http\ProcessCommandController;
use Illuminate\Support\Facades\Route;

Route::middleware('web')
    ->prefix('phpstan-report')
    ->group(static function (): void {
        Route::get('/', IndexReportController::class);
        Route::post('run', ProcessCommandController::class);
        Route::post('change-level', ChangeLevelController::class);
    });

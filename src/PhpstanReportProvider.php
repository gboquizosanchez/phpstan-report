<?php

declare(strict_types=1);

namespace Boquizo\PhpstanReport;

use Boquizo\PhpstanReport\Commands\InstallCommand;
use Illuminate\Support\ServiceProvider;

final class PhpstanReportProvider extends ServiceProvider
{
    public function register(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
            ]);
        }
    }

    public function boot(): void
    {
        $this->registerViews();

        $this->registerRoutes();

        $this->publishes([
            __DIR__.'/../public/vendor/phpstan-report' => $this->app->publicPath('vendor/phpstan-report'),
        ], 'phpstan-report-assets');
    }

    protected function registerViews(): void
    {
        $this->loadViewsFrom(
            path: __DIR__.'/../resources/views',
            namespace: 'phpstan-report',
        );
    }

    protected function registerRoutes(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }
}

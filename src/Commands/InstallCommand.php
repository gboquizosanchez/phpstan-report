<?php

declare(strict_types=1);

namespace Boquizo\PhpstanReport\Commands;

use Boquizo\PhpstanReport\Actions\ComposerPhpstanReportAction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;

final class InstallCommand extends Command
{
    /** @var string */
    protected $signature = 'install:phpstan-report';

    /** @var string */
    protected $description = 'Install PHPStan Report package and publish assets';

    public function handle(): int
    {
        $this->info('Installing PHPStan Report...');

        // Publish the assets
        $this->call('vendor:publish', [
            '--tag' => 'phpstan-report-assets',
            '--force' => true,
        ]);

        $this->addPhpstanScriptToComposer();

        $this->info('Establishing...');
        $result = ComposerPhpstanReportAction::execute();

        if ($result['success']) {
            $this->info('✅ PHPStan Report installed successfully.');
        }

        $this->info('Assets have been published to: public/vendor/phpstan-report');

        return self::SUCCESS;
    }

    private function addPhpstanScriptToComposer(): void
    {
        $composerPath = App::basePath('composer.json');

        if (File::exists($composerPath)) {
            $fileContent = File::get($composerPath);

            /** @var array<string, mixed>|null $composerContent */
            $composerContent = json_decode($fileContent, true);

            if (! is_array($composerContent)) {
                $composerContent = [];
            }

            if (! array_key_exists('scripts', $composerContent) || ! is_array($composerContent['scripts'])) {
                $composerContent['scripts'] = [];
            }

            if (! isset($composerContent['scripts']['phpstan-report'])) {
                $composerContent['scripts']['phpstan-report'] = [
                    'vendor/bin/phpstan analyse --memory-limit=2G --error-format=json > storage/app/phpstan-errors.json || exit 0',
                ];

                $encodedContent = json_encode($composerContent, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

                if ($encodedContent !== false) {
                    File::put($composerPath, $encodedContent);
                }
            }
        }
    }
}

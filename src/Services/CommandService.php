<?php

declare(strict_types=1);

namespace Boquizo\PhpstanReport\Services;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;

class CommandService
{
    private string $phpstanFile;

    public function __construct()
    {
        $this->phpstanFile = App::basePath('phpstan.neon');
    }

    public function process(): Process
    {
        $process = new Process(['composer', 'phpstan-report']);

        $process->setWorkingDirectory(App::basePath());
        $process->run();

        return $process;
    }

    public function createPhpstanFile(): void
    {
        $stubPath = __DIR__.'/../../stubs/phpstan.neon.stub';

        File::exists($stubPath)
            ? $this->copyStubFile($stubPath)
            : $this->establishLiteralConfig();
    }

    public function phpstanIsNotEstablished(): bool
    {
        return ! File::exists(App::basePath('phpstan.neon'));
    }

    private function copyStubFile(string $stubPath): void
    {
        File::copy($stubPath, $this->phpstanFile);
    }

    private function establishLiteralConfig(): void
    {
        $phpstanConfig = "parameters:\n    level: 3\n    paths:\n        - app\n";

        File::put($this->phpstanFile, $phpstanConfig);
    }
}

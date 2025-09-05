<?php

declare(strict_types=1);

namespace Boquizo\PhpstanReport\Actions;

use Boquizo\PhpstanReport\Services\CommandService;

final readonly class ComposerPhpstanReportAction
{
    public function __construct(
        private CommandService $service,
    ) {}

    /** @return array{success: bool, message: string} */
    public static function execute(): array
    {
        $service = new CommandService;

        return (new self($service))();
    }

    /** @return array{success: bool, message: string} */
    public function __invoke(): array
    {
        if ($this->service->phpstanIsNotEstablished()) {
            $this->service->createPhpstanFile();
        }

        return [
            'success' => $this->service->process()->isSuccessful(),
            'message' => 'Saved to storage/app/phpstan-errors.json',
        ];
    }
}

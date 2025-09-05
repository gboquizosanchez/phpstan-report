<?php

declare(strict_types=1);

namespace Boquizo\PhpstanReport\Http;

use Boquizo\PhpstanReport\Actions\ComposerPhpstanReportAction;
use Illuminate\Http\JsonResponse;

readonly class ProcessCommandController
{
    public function __invoke(): JsonResponse
    {
        return new JsonResponse(ComposerPhpstanReportAction::execute());
    }
}

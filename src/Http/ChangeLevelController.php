<?php

declare(strict_types=1);

namespace Boquizo\PhpstanReport\Http;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;

class ChangeLevelController
{
    public function __invoke(Request $request): JsonResponse
    {
        $level = $request->integer('level');

        if ($level < 0 || $level > 10) {
            return new JsonResponse([
                'error' => 'Invalid level',
            ], Response::HTTP_BAD_REQUEST);
        }

        $path = App::basePath('phpstan.neon');
        if (! File::exists($path)) {
            return new JsonResponse([
                'error' => 'phpstan.neon not found',
            ], Response::HTTP_NOT_FOUND);
        }

        /** @var string $content */
        $content = File::get($path);

        $newContent = preg_replace('/level:\s*\d+/', "level: $level", $content);
        if ($newContent === null) {
            return new JsonResponse([
                'error' => 'Failed to parse phpstan.neon',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        File::put($path, $newContent);

        return new JsonResponse([
            'success' => true,
        ]);
    }
}

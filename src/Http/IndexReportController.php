<?php

declare(strict_types=1);

namespace Gboquizo\PhpstanReport\Http;

use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View as ViewFacade;
use RuntimeException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class IndexReportController
{
    public function __invoke(Request $request): View|JsonResponse
    {
        if (! App::isLocal() && ! Config::boolean('app.debug')) {
            throw new NotFoundHttpException;
        }

        $jsonFile = App::storagePath('app/phpstan-errors.json');

        if (! file_exists($jsonFile)) {
            throw new RuntimeException('JSON file not found.');
        }

        /** @var string $content */
        $content = file_get_contents($jsonFile);

        if (str_starts_with($content, "\xFF\xFE")) {
            /** @var string $content */
            $content = mb_convert_encoding($content, 'UTF-8', 'UTF-16');
        }

        try {
            /**
             * @var array{
             *     level: int,
             *     filesCount: int,
             *     totals: array{
             *         file_errors: int
             *     },
             *     total: int,
             *     files: list<array{
             *         file: string,
             *         errors: int,
             *         messages: list<array{
             *             message: string,
             *             line: int,
             *             ignorable: bool,
             *             identifier: string,
             *             tip?: string
             *         }>
             *     }>
             * } $errors
             */
            $errors = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        } catch (Exception) {
            $errors = [
                'totals' => [
                    'errors' => 0,
                    'file_errors' => 1,
                ],
                'files' => [
                    'phpstan-errors.json' => [
                        'errors' => 1,
                        'messages' => [
                            [
                                'message' => 'phpstan-errors.json is not formatted properly',
                                'line' => -1,
                                'ignorable' => true,
                                'tip' => 'Check if your php code has a problem or generate again the file through command line',
                                'identifier' => 'fatal.error',
                            ],
                        ],
                    ],
                ],
            ];
        }

        $filesCollection = collect($errors['files'])
            ->mapWithKeys(
                /**
                 * @param array{
                 *     errors: int,
                 *     messages: list<array{
                 *         message: string,
                 *         line: int,
                 *         ignorable: bool,
                 *         identifier: string,
                 *         tip?: string
                 *     }>
                 * } $fileData
                 * @return array{
                 *     file: string,
                 *     errors: int,
                 *     messages: list<array{
                 *         message: string,
                 *         line: int,
                 *         ignorable: bool,
                 *         identifier: string,
                 *         tip?: string
                 *     }>
                 * }
                 */
                fn (array $fileData, int|string $fileName): array => [
                    $fileName => [
                        'file' => $fileName,
                        'errors' => $fileData['errors'],
                        'messages' => $fileData['messages'],
                    ],
                ],
            )->values();

        $page = (int) $request->query('page', '1');
        $perPage = (int) $request->query('perPage', '5');
        $total = $filesCollection->count();
        $slice = $filesCollection->slice(($page - 1) * $perPage, $perPage)->values();

        try {
            /** @var string $content */
            $content = file_get_contents(App::basePath('phpstan.neon'));
        } catch (Exception) {
            $content = '';
        }

        preg_match('/level:\s*(\d+)/', $content, $matches);

        $level = (int) ($matches[1] ?? 10);

        if ($request->wantsJson()) {
            return new JsonResponse([
                'level' => $level,
                'filesCount' => count($errors['files']),
                'files' => $slice->toArray(),
                'totals' => $errors['totals']['file_errors'],
                'total' => $total,
            ]);
        }

        return ViewFacade::make('phpstan-report::index', [
            'level' => $level,
            'errors' => $errors,
            'files' => $slice->toArray(),
            'filesCount' => count($errors['files']),
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage,
        ]);
    }
}

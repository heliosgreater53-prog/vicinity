<?php

declare(strict_types=1);

namespace App\Middleware;

use Core\Middleware;
use Core\Request;
use Core\Response;
use Core\Session;

/**
 * CsrfMiddleware – protects against Cross-Site Request Forgery.
 * Verifies _csrf_token on POST, PUT, PATCH, DELETE requests.
 */
class CsrfMiddleware implements Middleware
{
    /** @var string[] URIs to exclude from CSRF verification */
    protected array $except = [
        // e.g. 'api/*', 'webhook'
    ];

    public function handle(Request $request): ?Response
    {
        $method = $request->method();

        if (in_array($method, ['GET', 'HEAD', 'OPTIONS'], true)) {
            return null;
        }

        foreach ($this->except as $exceptUri) {
            if ($request->is($exceptUri)) {
                return null;
            }
        }

        /** @var Session $session */
        $session = app(Session::class);
        $token   = $request->post('_csrf_token')
            ?? $request->input('_csrf_token')
            ?? $request->header('x_csrf_token')
            ?? $request->header('X-CSRF-TOKEN');

        if (!$token || !$session->validateCsrf((string) $token)) {
            abort(419, 'Page expired due to invalid or missing CSRF token. Please refresh and try again.');
        }

        return null;
    }
}

<?php

declare(strict_types=1);

namespace App\Middleware;

use Core\Middleware;
use Core\Request;
use Core\Response;

/**
 * GuestMiddleware – ensures only guests can access the route (e.g. login, register).
 */
class GuestMiddleware implements Middleware
{
    public function handle(Request $request): ?Response
    {
        if (auth()->check()) {
            return redirect('/');
        }

        return null;
    }
}

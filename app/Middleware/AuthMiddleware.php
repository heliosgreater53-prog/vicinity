<?php

declare(strict_types=1);

namespace App\Middleware;

use Core\Middleware;
use Core\Request;
use Core\Response;
use Core\Session;

/**
 * AuthMiddleware – restricts access to authenticated users only.
 */
class AuthMiddleware implements Middleware
{
    public function handle(Request $request): ?Response
    {
        if (auth()->guest()) {
            /** @var Session $session */
            $session = app(Session::class);
            $session->flash('error', 'Please log in to continue.');
            $session->set('_intended_url', $request->uri());

            return redirect('/login');
        }

        return null;
    }
}

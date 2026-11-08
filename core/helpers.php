<?php

declare(strict_types=1);

use Core\Application;
use Core\Auth;
use Core\Database;
use Core\Request;
use Core\Response;
use Core\Session;
use Core\View;

if (!function_exists('env')) {
    /**
     * Get an environment variable or default.
     */
    function env(string $key, mixed $default = null): mixed
    {
        $value = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);

        if ($value === false || $value === null) {
            return $default;
        }

        return match (strtolower((string) $value)) {
            'true', '(true)'   => true,
            'false', '(false)' => false,
            'empty', '(empty)' => '',
            'null', '(null)'   => null,
            default            => $value,
        };
    }
}

if (!function_exists('app')) {
    /**
     * Get the Application singleton or resolve a service from the container.
     */
    function app(?string $abstract = null): mixed
    {
        $app = Application::getInstance();

        if ($abstract === null) {
            return $app;
        }

        return $app->make($abstract);
    }
}

if (!function_exists('request')) {
    /**
     * Get current HTTP request instance or input value.
     */
    function request(?string $key = null, mixed $default = null): mixed
    {
        $req = app()->request;
        if ($key === null) {
            return $req;
        }
        return $req->input($key, $default);
    }
}

if (!function_exists('response')) {
    /**
     * Create an HTTP response instance.
     */
    function response(?string $content = '', int $status = 200, array $headers = []): Response
    {
        return new Response($content ?? '', $status, $headers);
    }
}

if (!function_exists('view')) {
    /**
     * Render a view template and return a Response.
     */
    function view(string $template, array $data = []): Response
    {
        $v = new View($template, $data);
        return new Response($v->render(), 200, ['Content-Type' => 'text/html; charset=UTF-8']);
    }
}

if (!function_exists('json')) {
    /**
     * Return a JSON response.
     */
    function json(mixed $data, int $status = 200, array $headers = []): Response
    {
        return Response::json($data, $status, $headers);
    }
}

if (!function_exists('redirect')) {
    /**
     * Create a redirect response.
     */
    function redirect(string $url, int $status = 302): Response
    {
        return Response::redirect($url, $status);
    }
}

if (!function_exists('back')) {
    /**
     * Redirect to the previous page.
     */
    function back(): Response
    {
        $previous = $_SERVER['HTTP_REFERER'] ?? '/home';
        return redirect($previous);
    }
}

if (!function_exists('session')) {
    /**
     * Get or set session values, or return Session instance.
     */
    function session(mixed $key = null, mixed $default = null): mixed
    {
        /** @var Session $session */
        $session = app(Session::class);

        if ($key === null) {
            return $session;
        }

        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $session->set($k, $v);
            }
            return null;
        }

        return $session->get($key, $default);
    }
}

if (!function_exists('now')) {
    /**
     * Get current timestamp in Y-m-d H:i:s format.
     */
    function now(string $format = 'Y-m-d H:i:s'): string
    {
        return date($format);
    }
}

if (!function_exists('csrf_token')) {
    /**
     * Get current session CSRF token.
     */
    function csrf_token(): string
    {
        /** @var Session $session */
        $session = app(Session::class);
        return $session->csrfToken();
    }
}

if (!function_exists('csrf_field')) {
    /**
     * Generate HTML hidden input for CSRF protection.
     */
    function csrf_field(): string
    {
        /** @var Session $session */
        $session = app(Session::class);
        return $session->csrfField();
    }
}

if (!function_exists('old')) {
    /**
     * Retrieve flashed old input value.
     */
    function old(string $key, mixed $default = ''): mixed
    {
        /** @var Session $session */
        $session = app(Session::class);
        return $session->getFlash('_old_' . $key, $default);
    }
}

if (!function_exists('base_path_url')) {
    /**
     * Detect base path from script execution environment.
     */
    function base_path_url(): string
    {
        if (isset($_SERVER['SCRIPT_NAME'])) {
            $dir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
            if ($dir !== '/' && $dir !== '.' && $dir !== '') {
                return rtrim($dir, '/');
            }
        }
        return '';
    }
}

if (!function_exists('url')) {
    /**
     * Generate an absolute or root-relative URL.
     */
    function url(string $path = ''): string
    {
        $cleanPath = '/' . ltrim($path, '/');
        $base = base_path_url();
        return ($base !== '' ? $base : '') . $cleanPath;
    }
}

if (!function_exists('route')) {
    /**
     * Generate URL for a named route.
     */
    function route(string $name, array $params = []): string
    {
        return url(app()->router->route($name, $params));
    }
}

if (!function_exists('asset')) {
    /**
     * Generate URL for public assets.
     */
    function asset(string $path): string
    {
        $cleanPath = ltrim($path, '/');
        return url('/' . $cleanPath);
    }
}

if (!function_exists('config')) {
    /**
     * Simple config accessor fallback to env.
     */
    function config(string $key, mixed $default = null): mixed
    {
        return env(strtoupper(str_replace('.', '_', $key)), $default);
    }
}

if (!function_exists('abort')) {
    /**
     * Abort execution with HTTP error status.
     */
    function abort(int $code = 404, string $message = ''): void
    {
        http_response_code($code);
        $title = match ($code) {
            400 => 'Bad Request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Page Not Found',
            419 => 'Page Expired (CSRF Token Mismatch)',
            500 => 'Internal Server Error',
            default => 'Error',
        };

        $msg = $message !== '' ? $message : $title;

        echo "<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><title>{$code} - {$title}</title><style>body{font-family:system-ui,-apple-system,sans-serif;background:#0f172a;color:#f8fafc;display:flex;align-items:center;justify-content:center;height:100vh;margin:0;text-align:center}h1{font-size:3rem;margin:0 0 .5rem}p{color:#94a3b8;font-size:1.1rem;margin-bottom:1.5rem}a{display:inline-block;padding:.75rem 1.5rem;background:#16a34a;color:#fff;text-decoration:none;border-radius:8px;font-weight:600}</style></head><body><div><h1>{$code}</h1><p>{$msg}</p><a href='/home'>Return to Feed</a></div></body></html>";
        exit;
    }
}

if (!function_exists('auth')) {
    /**
     * Get Auth helper instance.
     */
    function auth(): Auth
    {
        return app(Auth::class);
    }
}

if (!function_exists('user')) {
    /**
     * Get current authenticated user or null.
     */
    function user(): mixed
    {
        return auth()->user();
    }
}

if (!function_exists('e')) {
    /**
     * HTML entity encode string.
     */
    function e(?string $value): string
    {
        return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('dd')) {
    /**
     * Dump variables and die.
     */
    function dd(...$vars): void
    {
        header('Content-Type: text/html; charset=UTF-8');
        echo '<pre style="background:#1e1e2e;color:#cdd6f4;padding:1.5rem;border-radius:8px;font-family:Consolas,monospace;font-size:14px;line-height:1.5;overflow:auto;margin:1rem;">';
        foreach ($vars as $var) {
            var_dump($var);
            echo "\n";
        }
        echo '</pre>';
        exit(1);
    }
}

if (!function_exists('dump')) {
    /**
     * Dump variables without dying.
     */
    function dump(...$vars): void
    {
        echo '<pre style="background:#1e1e2e;color:#cdd6f4;padding:1rem;border-radius:8px;font-family:Consolas,monospace;font-size:14px;line-height:1.5;overflow:auto;margin:1rem;">';
        foreach ($vars as $var) {
            var_dump($var);
            echo "\n";
        }
        echo '</pre>';
    }
}

<?php

declare(strict_types=1);

namespace Core;

/**
 * Session – wraps PHP's native session with a cleaner API.
 *
 * Features:
 *   - Typed get/set/forget/flush
 *   - Flash messages (survive exactly one redirect)
 *   - CSRF token generation & validation
 */
class Session
{
    private bool $started = false;

    public function __construct()
    {
        $this->start();
    }

    // -------------------------------------------------------------------------
    // Lifecycle
    // -------------------------------------------------------------------------

    public function start(): void
    {
        if ($this->started || session_status() === PHP_SESSION_ACTIVE) {
            $this->started = true;
            return;
        }

        $lifetime = (int) env('SESSION_LIFETIME', '120');
        $secure   = env('SESSION_SECURE', 'false') === 'true';

        if (!headers_sent()) {
            session_set_cookie_params([
                'lifetime' => $lifetime * 60,
                'path'     => '/',
                'secure'   => $secure,
                'httponly' => true,
                'samesite' => 'Lax',
            ]);

            session_start();
        } elseif (session_status() !== PHP_SESSION_ACTIVE) {
            @session_start();
        }

        $this->started = true;

        // Age flash messages: remove old ones, promote "new" to "current"
        $this->ageFlash();
    }

    public function regenerate(bool $deleteOld = true): void
    {
        session_regenerate_id($deleteOld);
    }

    public function destroy(): void
    {
        session_unset();
        session_destroy();
        $this->started = false;
    }

    // -------------------------------------------------------------------------
    // Core get / set / forget
    // -------------------------------------------------------------------------

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->dotGet($_SESSION, $key, $default);
    }

    public function set(string $key, mixed $value): void
    {
        $this->dotSet($_SESSION, $key, $value);
    }

    public function has(string $key): bool
    {
        return $this->get($key) !== null;
    }

    public function forget(string $key): void
    {
        $this->dotUnset($_SESSION, $key);
    }

    public function flush(): void
    {
        $_SESSION = [];
    }

    public function all(): array
    {
        return $_SESSION ?? [];
    }

    // -------------------------------------------------------------------------
    // Flash messages
    // -------------------------------------------------------------------------

    /**
     * Set a flash value (available until next request).
     */
    public function flash(string $key, mixed $value): void
    {
        $_SESSION['_flash']['new'][$key] = $value;
    }

    /**
     * Retrieve a flash value for the current request.
     */
    public function getFlash(string $key, mixed $default = null): mixed
    {
        return $_SESSION['_flash']['current'][$key] ?? $default;
    }

    public function hasFlash(string $key): bool
    {
        return isset($_SESSION['_flash']['current'][$key]);
    }

    /**
     * Keep a flash message for one more request.
     */
    public function reflash(string $key): void
    {
        $value = $this->getFlash($key);
        if ($value !== null) {
            $this->flash($key, $value);
        }
    }

    private function ageFlash(): void
    {
        $_SESSION['_flash']['current'] = $_SESSION['_flash']['new'] ?? [];
        $_SESSION['_flash']['new']     = [];
    }

    // -------------------------------------------------------------------------
    // CSRF
    // -------------------------------------------------------------------------

    /**
     * Get or create the CSRF token for this session.
     */
    public function csrfToken(): string
    {
        if (!isset($_SESSION['_csrf_token'])) {
            $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['_csrf_token'];
    }

    /**
     * Validate a submitted CSRF token.
     */
    public function validateCsrf(string $token): bool
    {
        return hash_equals($this->csrfToken(), $token);
    }

    /**
     * Return an HTML hidden input with the CSRF token.
     */
    public function csrfField(): string
    {
        $token = htmlspecialchars($this->csrfToken(), ENT_QUOTES);
        return "<input type=\"hidden\" name=\"_csrf_token\" value=\"{$token}\">";
    }

    // -------------------------------------------------------------------------
    // Dot-notation helpers
    // -------------------------------------------------------------------------

    private function dotGet(array $array, string $key, mixed $default): mixed
    {
        if (array_key_exists($key, $array)) {
            return $array[$key];
        }

        foreach (explode('.', $key) as $segment) {
            if (!is_array($array) || !array_key_exists($segment, $array)) {
                return $default;
            }
            $array = $array[$segment];
        }

        return $array;
    }

    private function dotSet(array &$array, string $key, mixed $value): void
    {
        $keys = explode('.', $key);
        $last = array_pop($keys);

        foreach ($keys as $segment) {
            if (!isset($array[$segment]) || !is_array($array[$segment])) {
                $array[$segment] = [];
            }
            $array = &$array[$segment];
        }

        $array[$last] = $value;
    }

    private function dotUnset(array &$array, string $key): void
    {
        $keys = explode('.', $key);
        $last = array_pop($keys);

        foreach ($keys as $segment) {
            if (!isset($array[$segment])) {
                return;
            }
            $array = &$array[$segment];
        }

        unset($array[$last]);
    }
}

<?php

declare(strict_types=1);

namespace Core;

/**
 * Request – wraps the current HTTP request.
 *
 * Provides typed access to:
 *   - URI / method
 *   - GET, POST, JSON body parameters
 *   - Uploaded files
 *   - Request headers
 *   - Input validation shortcut
 */
class Request
{
    private array $getParams;
    private array $postParams;
    private array $serverParams;
    private array $files;
    private array $jsonBody;
    private array $headers;

    public function __construct()
    {
        $this->getParams    = $_GET;
        $this->postParams   = $_POST;
        $this->serverParams = $_SERVER;
        $this->files        = $_FILES;
        $this->headers      = $this->parseHeaders();
        $this->jsonBody     = $this->parseJson();
    }

    // -------------------------------------------------------------------------
    // Method & URI
    // -------------------------------------------------------------------------

    public function method(): string
    {
        return strtoupper($this->serverParams['REQUEST_METHOD'] ?? 'GET');
    }

    public function uri(): string
    {
        $uri = $this->serverParams['REQUEST_URI'] ?? '/';

        // Strip query string
        if (($pos = strpos($uri, '?')) !== false) {
            $uri = substr($uri, 0, $pos);
        }

        // Strip script subfolder (e.g. /vicinity/public/index.php → /)
        $scriptDir = dirname($this->serverParams['SCRIPT_NAME'] ?? '');
        if ($scriptDir !== '/' && str_starts_with($uri, $scriptDir)) {
            $uri = substr($uri, strlen($scriptDir));
        }

        return '/' . ltrim($uri, '/');
    }

    public function fullUrl(): string
    {
        $scheme = (!empty($this->serverParams['HTTPS']) && $this->serverParams['HTTPS'] !== 'off') ? 'https' : 'http';
        $host   = $this->serverParams['HTTP_HOST'] ?? 'localhost';
        return $scheme . '://' . $host . ($this->serverParams['REQUEST_URI'] ?? '/');
    }

    public function isMethod(string $method): bool
    {
        return $this->method() === strtoupper($method);
    }

    public function isAjax(): bool
    {
        return ($this->header('X-Requested-With') === 'XMLHttpRequest');
    }

    public function isJson(): bool
    {
        return str_contains($this->header('Content-Type') ?? '', 'application/json');
    }

    // -------------------------------------------------------------------------
    // Input access
    // -------------------------------------------------------------------------

    /**
     * Get a value from GET, POST, or JSON body (in that priority order).
     */
    public function input(string $key, mixed $default = null): mixed
    {
        return $this->postParams[$key]
            ?? $this->jsonBody[$key]
            ?? $this->getParams[$key]
            ?? $default;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->getParams[$key] ?? $default;
    }

    public function post(string $key, mixed $default = null): mixed
    {
        return $this->postParams[$key] ?? $default;
    }

    public function json(string $key, mixed $default = null): mixed
    {
        return $this->jsonBody[$key] ?? $default;
    }

    /**
     * Return only specified keys from input.
     *
     * @return array<string, mixed>
     */
    public function only(string ...$keys): array
    {
        $result = [];
        foreach ($keys as $key) {
            $result[$key] = $this->input($key);
        }
        return $result;
    }

    /**
     * Return all input except specified keys.
     *
     * @return array<string, mixed>
     */
    public function except(string ...$keys): array
    {
        $all = array_merge($this->getParams, $this->postParams, $this->jsonBody);
        return array_diff_key($all, array_flip($keys));
    }

    public function all(): array
    {
        return array_merge($this->getParams, $this->postParams, $this->jsonBody);
    }

    public function has(string $key): bool
    {
        return $this->input($key) !== null;
    }

    public function filled(string $key): bool
    {
        $val = $this->input($key);
        return $val !== null && $val !== '';
    }

    // -------------------------------------------------------------------------
    // Files
    // -------------------------------------------------------------------------

    public function file(string $name): array|null
    {
        return $this->files[$name] ?? null;
    }

    public function hasFile(string $name): bool
    {
        return isset($this->files[$name]) && $this->files[$name]['error'] === UPLOAD_ERR_OK;
    }

    // -------------------------------------------------------------------------
    // Headers
    // -------------------------------------------------------------------------

    public function header(string $name, mixed $default = null): mixed
    {
        $normalized = strtolower(str_replace('-', '_', $name));
        return $this->headers[$normalized] ?? $default;
    }

    public function bearerToken(): ?string
    {
        $auth = $this->header('Authorization', '');
        if (str_starts_with($auth, 'Bearer ')) {
            return substr($auth, 7);
        }
        return null;
    }

    public function ip(): string
    {
        return $this->serverParams['REMOTE_ADDR'] ?? '0.0.0.0';
    }

    // -------------------------------------------------------------------------
    // Quick validation
    // -------------------------------------------------------------------------

    /**
     * Validate request inputs. Returns an array of errors (empty = valid).
     *
     * Example rules: ['email' => 'required|email', 'name' => 'required|min:2|max:100']
     *
     * @param array<string, string> $rules
     * @return array<string, string[]>  field → error messages
     */
    public function validate(array $rules): array
    {
        return Validator::make($this->all(), $rules);
    }

    // -------------------------------------------------------------------------
    // Internal parsers
    // -------------------------------------------------------------------------

    private function parseHeaders(): array
    {
        $headers = [];

        foreach ($this->serverParams as $key => $value) {
            if (str_starts_with($key, 'HTTP_')) {
                $normalized          = strtolower(substr($key, 5));
                $headers[$normalized] = $value;
            } elseif (in_array($key, ['CONTENT_TYPE', 'CONTENT_LENGTH'], true)) {
                $normalized          = strtolower($key);
                $headers[$normalized] = $value;
            }
        }

        return $headers;
    }

    private function parseJson(): array
    {
        if (!$this->isJson()) {
            return [];
        }

        $raw = file_get_contents('php://input');

        if (!$raw) {
            return [];
        }

        $decoded = json_decode($raw, true);
        return is_array($decoded) ? $decoded : [];
    }
}

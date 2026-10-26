<?php

declare(strict_types=1);

namespace Core;

/**
 * Response – wraps the HTTP response sent back to the client.
 */
class Response
{
    private string $body;
    private int    $statusCode;
    /** @var array<string, string> */
    private array  $headers;

    public function __construct(string $body = '', int $statusCode = 200, array $headers = [])
    {
        $this->body       = $body;
        $this->statusCode = $statusCode;
        $this->headers    = $headers;
    }

    // -------------------------------------------------------------------------
    // Factories
    // -------------------------------------------------------------------------

    public static function make(string $body, int $status = 200, array $headers = []): static
    {
        return new static($body, $status, $headers);
    }

    public static function json(mixed $data, int $status = 200): static
    {
        return new static(
            json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
            $status,
            ['Content-Type' => 'application/json']
        );
    }

    /**
     * Issue an HTTP redirect.
     */
    public static function redirect(string $url, int $status = 302): static
    {
        return new static('', $status, ['Location' => $url]);
    }

    /**
     * Redirect back to the previous page (via Referer header).
     */
    public static function back(int $status = 302): static
    {
        $referer = $_SERVER['HTTP_REFERER'] ?? '/';
        return static::redirect($referer, $status);
    }

    // -------------------------------------------------------------------------
    // Fluent setters
    // -------------------------------------------------------------------------

    public function withStatus(int $status): static
    {
        $clone             = clone $this;
        $clone->statusCode = $status;
        return $clone;
    }

    public function withHeader(string $name, string $value): static
    {
        $clone                  = clone $this;
        $clone->headers[$name]  = $value;
        return $clone;
    }

    public function withBody(string $body): static
    {
        $clone       = clone $this;
        $clone->body = $body;
        return $clone;
    }

    /**
     * Store a flash message in the session then redirect.
     */
    public function with(string $key, mixed $value): static
    {
        session()->flash($key, $value);
        return $this;
    }

    // -------------------------------------------------------------------------
    // Output
    // -------------------------------------------------------------------------

    public function send(): void
    {
        http_response_code($this->statusCode);

        foreach ($this->headers as $name => $value) {
            header("{$name}: {$value}");
        }

        echo $this->body;
    }

    // -------------------------------------------------------------------------
    // Accessors
    // -------------------------------------------------------------------------

    public function getBody(): string        { return $this->body; }
    public function getContent(): string    { return $this->body; }
    public function getStatus(): int         { return $this->statusCode; }
    public function getStatusCode(): int     { return $this->statusCode; }
    public function getHeaders(): array      { return $this->headers; }
}

<?php

declare(strict_types=1);

namespace Core;

/**
 * View – renders PHP template files with layout support.
 *
 * Usage:
 *   return view('home.index', ['user' => $user]);
 *
 * Inside a view you can call:
 *   $this->extend('layouts.main')    → use a layout
 *   $this->section('title', 'Home')  → push a named section
 *   $this->yield('title')            → output section in layout
 *   $this->partial('partials.nav')   → include a sub-view
 */
class View
{
    /** @var string Dot-separated view path relative to app/Views/ */
    private string $viewName;

    /** @var array<string, mixed> Data passed to the view */
    private array $data;

    /** @var string|null Layout to wrap around this view */
    private ?string $layout = null;

    /** @var array<string, string> Named sections captured via section() */
    private array $sections = [];

    /** @var string Name of the currently open section */
    private ?string $currentSection = null;

    private static string $viewsPath = '';

    public function __construct(string $viewName, array $data = [])
    {
        $this->viewName = $viewName;
        $this->data     = $data;

        if (static::$viewsPath === '') {
            static::$viewsPath = dirname(__DIR__) . '/app/Views';
        }
    }

    public static function setViewsPath(string $path): void
    {
        static::$viewsPath = rtrim($path, '/\\');
    }

    // -------------------------------------------------------------------------
    // Render
    // -------------------------------------------------------------------------

    public function render(): string
    {
        $file = $this->resolveFile($this->viewName);

        // Render the view content
        $content = $this->renderFile($file, $this->data);

        // If a layout was set, wrap it
        if ($this->layout !== null) {
            $layoutFile = $this->resolveFile($this->layout);

            // Make $content available as the 'content' section
            $this->sections['content'] = $content;

            return $this->renderFile($layoutFile, $this->data);
        }

        return $content;
    }

    public function __toString(): string
    {
        return $this->render();
    }

    // -------------------------------------------------------------------------
    // Template helpers (callable inside .php view files via $this->method())
    // -------------------------------------------------------------------------

    public function extend(string $layout): void
    {
        $this->layout = $layout;
    }

    public function section(string $name, string $content = ''): void
    {
        if ($content !== '') {
            $this->sections[$name] = $content;
            return;
        }

        // Otherwise start output buffering
        $this->currentSection = $name;
        ob_start();
    }

    public function endSection(): void
    {
        if ($this->currentSection === null) {
            throw new \RuntimeException('endSection() called without matching section().');
        }

        $this->sections[$this->currentSection] = ob_get_clean();
        $this->currentSection = null;
    }

    public function yield(string $name, string $default = ''): string
    {
        return $this->sections[$name] ?? $default;
    }

    /**
     * Include a sub-view (partial) with optional data.
     */
    public function partial(string $viewName, array $data = []): string
    {
        $sub = new static($viewName, array_merge($this->data, $data));
        return $sub->render();
    }

    /**
     * Escape a value for safe HTML output.
     */
    public function e(mixed $value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Output CSRF hidden field.
     */
    public function csrf(): string
    {
        return session()->csrfField();
    }

    /**
     * Generate a named route URL.
     */
    public function route(string $name, array $params = []): string
    {
        return app()->router->route($name, $params);
    }

    /**
     * Get a flashed session message.
     */
    public function flash(string $key, mixed $default = null): mixed
    {
        return session()->getFlash($key, $default);
    }

    // -------------------------------------------------------------------------
    // Internal file resolution & rendering
    // -------------------------------------------------------------------------

    private function resolveFile(string $dotPath): string
    {
        $relativePath = str_replace('.', DIRECTORY_SEPARATOR, $dotPath) . '.php';
        $file         = static::$viewsPath . DIRECTORY_SEPARATOR . $relativePath;

        if (!file_exists($file)) {
            throw new \RuntimeException("View [{$dotPath}] not found at [{$file}].");
        }

        return $file;
    }

    private function renderFile(string $file, array $data): string
    {
        // Make $this available so views can call $this->extend(), $this->yield(), etc.
        $view = $this;

        // Extract data into local scope
        extract($data, EXTR_SKIP);

        ob_start();
        require $file;
        return ob_get_clean();
    }
}

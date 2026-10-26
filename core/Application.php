<?php

declare(strict_types=1);

namespace Core;

/**
 * Application – bootstraps the framework.
 *
 * Responsibilities:
 *  - Loads environment variables
 *  - Registers core service bindings
 *  - Runs the HTTP lifecycle (Request → Router → Response)
 */
class Application
{
    /** @var Application|null Singleton instance */
    private static ?Application $instance = null;

    /** @var array<string, mixed> Service container bindings */
    private array $bindings = [];

    /** @var array<string, mixed> Shared (singleton) instances */
    private array $instances = [];

    public readonly string $rootPath;
    public readonly Router  $router;
    public readonly Request $request;

    private function __construct(string $rootPath)
    {
        $this->rootPath = rtrim($rootPath, '/\\');
        $this->loadEnvironment();
        $this->bootCoreServices();
    }

    // -------------------------------------------------------------------------
    // Singleton access
    // -------------------------------------------------------------------------

    public static function getInstance(string $rootPath = ''): self
    {
        if (self::$instance === null) {
            if ($rootPath === '') {
                throw new \RuntimeException('Application rootPath must be provided on first call.');
            }
            self::$instance = new self($rootPath);
        }

        return self::$instance;
    }

    // -------------------------------------------------------------------------
    // Environment loading
    // -------------------------------------------------------------------------

    private function loadEnvironment(): void
    {
        $envFile = $this->rootPath . DIRECTORY_SEPARATOR . '.env';

        if (!file_exists($envFile)) {
            return; // Fall back to system env vars / defaults
        }

        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            $line = trim($line);

            // Skip comments
            if (str_starts_with($line, '#') || $line === '') {
                continue;
            }

            if (!str_contains($line, '=')) {
                continue;
            }

            [$key, $value] = explode('=', $line, 2);
            $key   = trim($key);
            $value = trim($value);

            // Strip inline comments
            if (($pos = strpos($value, ' #')) !== false) {
                $value = trim(substr($value, 0, $pos));
            }

            // Strip surrounding quotes
            if (preg_match('/^(["\'])(.*)\\1$/', $value, $m)) {
                $value = $m[2];
            }

            if (!array_key_exists($key, $_ENV)) {
                $_ENV[$key]    = $value;
                $_SERVER[$key] = $value;
                putenv("{$key}={$value}");
            }
        }
    }

    // -------------------------------------------------------------------------
    // Core service boot
    // -------------------------------------------------------------------------

    private function bootCoreServices(): void
    {
        // Bind core services lazily
        $this->bind(Database::class, fn() => Database::getInstance());
        $this->bind(Session::class,  fn() => new Session());
        $this->bind(Auth::class,     fn() => new Auth($this->make(Session::class)));

        // Request is needed immediately for routing
        $this->request = new Request();
        $this->router  = new Router($this->request);

        // Start session
        $this->make(Session::class);
    }

    // -------------------------------------------------------------------------
    // Service Container
    // -------------------------------------------------------------------------

    /**
     * Bind an abstract key to a factory closure.
     */
    public function bind(string $abstract, \Closure $factory): void
    {
        $this->bindings[$abstract] = $factory;
    }

    /**
     * Resolve a binding (creates a new instance each time).
     */
    public function make(string $abstract): mixed
    {
        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }

        if (isset($this->bindings[$abstract])) {
            $instance = ($this->bindings[$abstract])($this);
            $this->instances[$abstract] = $instance;
            return $instance;
        }

        // Attempt auto-resolution
        if (class_exists($abstract)) {
            return new $abstract();
        }

        throw new \RuntimeException("No binding found for [{$abstract}].");
    }

    // -------------------------------------------------------------------------
    // HTTP Lifecycle
    // -------------------------------------------------------------------------

    public function run(): void
    {
        try {
            $response = $this->router->dispatch();
            $response->send();
        } catch (\Throwable $e) {
            $this->handleException($e);
        }
    }

    private function handleException(\Throwable $e): void
    {
        $debug = env('APP_DEBUG', 'false') === 'true';

        http_response_code(500);

        if ($debug) {
            echo '<pre style="background:#1e1e2e;color:#cdd6f4;padding:24px;font-family:monospace;font-size:13px;">';
            echo '<strong style="color:#f38ba8">' . htmlspecialchars(get_class($e)) . '</strong>: ';
            echo htmlspecialchars($e->getMessage()) . PHP_EOL . PHP_EOL;
            echo htmlspecialchars($e->getTraceAsString());
            echo '</pre>';
        } else {
            echo '<h1>500 – Internal Server Error</h1><p>Something went wrong. Please try again later.</p>';
        }
    }
}

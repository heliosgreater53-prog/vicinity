<?php

declare(strict_types=1);

namespace Core;

/**
 * Router – registers and dispatches HTTP routes.
 *
 * Features:
 *  - Named routes with `->name()`
 *  - Route parameters  :id, :slug …
 *  - Middleware stacks per route / route group
 *  - RESTful resource helper
 *  - URL generator via `route(name, params)`
 */
class Router
{
    /** @var array<string, array<int, array{pattern:string, handler:mixed, middleware:string[], name:string|null}>> */
    private array $routes = [];

    /** @var array<string, string> name → pattern map for URL generation */
    private array $namedRoutes = [];

    /** @var string[] Current group middleware stack */
    private array $groupMiddleware = [];

    /** @var string Current group prefix */
    private string $groupPrefix = '';

    private Request $request;

    // Registered route (fluent interface target)
    private ?array $lastRoute = null;
    private string $lastMethod = '';

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    // -------------------------------------------------------------------------
    // Route Registration
    // -------------------------------------------------------------------------

    public function get(string $uri, mixed $handler): static
    {
        return $this->addRoute('GET', $uri, $handler);
    }

    public function post(string $uri, mixed $handler): static
    {
        return $this->addRoute('POST', $uri, $handler);
    }

    public function put(string $uri, mixed $handler): static
    {
        return $this->addRoute('PUT', $uri, $handler);
    }

    public function patch(string $uri, mixed $handler): static
    {
        return $this->addRoute('PATCH', $uri, $handler);
    }

    public function delete(string $uri, mixed $handler): static
    {
        return $this->addRoute('DELETE', $uri, $handler);
    }

    /**
     * Register a full RESTful resource.
     *
     * GET    /resource            → index
     * GET    /resource/create     → create
     * POST   /resource            → store
     * GET    /resource/:id        → show
     * GET    /resource/:id/edit   → edit
     * PUT    /resource/:id        → update
     * DELETE /resource/:id        → destroy
     */
    public function resource(string $base, string $controller): void
    {
        $name = ltrim($base, '/');

        $this->get($base,               [$controller, 'index'])->name("{$name}.index");
        $this->get("{$base}/create",     [$controller, 'create'])->name("{$name}.create");
        $this->post($base,              [$controller, 'store'])->name("{$name}.store");
        $this->get("{$base}/:id",        [$controller, 'show'])->name("{$name}.show");
        $this->get("{$base}/:id/edit",   [$controller, 'edit'])->name("{$name}.edit");
        $this->put("{$base}/:id",        [$controller, 'update'])->name("{$name}.update");
        $this->delete("{$base}/:id",     [$controller, 'destroy'])->name("{$name}.destroy");
    }

    // -------------------------------------------------------------------------
    // Route Groups
    // -------------------------------------------------------------------------

    /**
     * @param array{prefix?:string, middleware?:string[]} $attributes
     */
    public function group(array $attributes, \Closure $callback): void
    {
        $previousPrefix     = $this->groupPrefix;
        $previousMiddleware = $this->groupMiddleware;

        $this->groupPrefix     .= ($attributes['prefix'] ?? '');
        $this->groupMiddleware  = array_merge(
            $this->groupMiddleware,
            $attributes['middleware'] ?? []
        );

        $callback($this);

        $this->groupPrefix     = $previousPrefix;
        $this->groupMiddleware = $previousMiddleware;
    }

    // -------------------------------------------------------------------------
    // Fluent modifiers
    // -------------------------------------------------------------------------

    public function middleware(string|array $middleware): static
    {
        if (empty($this->lastMethod) || empty($this->routes[$this->lastMethod])) {
            return $this;
        }

        $middleware = (array) $middleware;
        $idx = \array_key_last($this->routes[$this->lastMethod]);
        $this->routes[$this->lastMethod][$idx]['middleware']
            = array_merge(
                $this->routes[$this->lastMethod][$idx]['middleware'],
                $middleware
            );

        return $this;
    }

    public function name(string $name): static
    {
        if (empty($this->lastMethod) || empty($this->routes[$this->lastMethod])) {
            return $this;
        }

        $idx = \array_key_last($this->routes[$this->lastMethod]);
        $this->routes[$this->lastMethod][$idx]['name'] = $name;
        $this->namedRoutes[$name] = $this->routes[$this->lastMethod][$idx]['pattern'];

        return $this;
    }

    // -------------------------------------------------------------------------
    // URL Generation
    // -------------------------------------------------------------------------

    /**
     * Generate a URL for a named route.
     *
     * @param array<string, string> $params  Route parameters to substitute
     */
    public function route(string $name, array $params = []): string
    {
        if (!isset($this->namedRoutes[$name])) {
            throw new \InvalidArgumentException("Route [{$name}] not defined.");
        }

        $pattern = $this->namedRoutes[$name];

        foreach ($params as $key => $value) {
            $pattern = str_replace(":{$key}", (string) $value, $pattern);
        }

        return '/' . ltrim($pattern, '/');
    }

    // -------------------------------------------------------------------------
    // Dispatch
    // -------------------------------------------------------------------------

    public function dispatch(): Response
    {
        $method = $this->request->method();
        $uri    = $this->request->uri();

        // Support method spoofing via _method field
        if ($method === 'POST' && $this->request->post('_method')) {
            $method = strtoupper($this->request->post('_method'));
        }

        // Try matching in current method then fallback to any
        $routeSets = $this->routes[$method] ?? [];

        foreach ($routeSets as $route) {
            $params = $this->matchRoute($route['pattern'], $uri);

            if ($params === false) {
                continue;
            }

            // Run middleware stack
            $middlewareResponse = $this->runMiddleware($route['middleware'], $this->request);
            if ($middlewareResponse instanceof Response) {
                return $middlewareResponse;
            }

            return $this->callHandler($route['handler'], $params);
        }

        return $this->notFound();
    }

    // -------------------------------------------------------------------------
    // Internal helpers
    // -------------------------------------------------------------------------

    private function addRoute(string $method, string $uri, mixed $handler): static
    {
        $pattern = $this->groupPrefix . '/' . ltrim($uri, '/');
        $pattern = rtrim($pattern, '/') ?: '/';

        $this->routes[$method][] = [
            'pattern'    => $pattern,
            'handler'    => $handler,
            'middleware' => $this->groupMiddleware,
            'name'       => null,
        ];

        $this->lastMethod = $method;
        $this->lastRoute  = &$this->routes[$method][\array_key_last($this->routes[$method])];

        return $this;
    }

    /**
     * Match a URI against a route pattern.
     *
     * Returns an array of named params on match, or false.
     *
     * @return array<string, string>|false
     */
    private function matchRoute(string $pattern, string $uri): array|false
    {
        // Normalize
        $pattern = rtrim($pattern, '/') ?: '/';
        $uri     = rtrim($uri, '/')     ?: '/';

        if ($pattern === $uri) {
            return [];
        }

        // Build regex from pattern
        $regex = preg_replace_callback('/:([a-zA-Z_]+)/', function ($m) {
            return '(?P<' . $m[1] . '>[^/]+)';
        }, $pattern);

        $regex = '#^' . $regex . '$#';

        if (!preg_match($regex, $uri, $matches)) {
            return false;
        }

        // Filter named captures only
        return array_filter($matches, fn($k) => !is_int($k), ARRAY_FILTER_USE_KEY);
    }

    private function callHandler(mixed $handler, array $params): Response
    {
        if ($handler instanceof \Closure) {
            $result = $handler($this->request, ...array_values($params));
        } elseif (is_array($handler) && count($handler) === 2) {
            [$class, $method] = $handler;
            $controller = new $class();
            $result = $controller->$method($this->request, ...array_values($params));
        } else {
            throw new \RuntimeException('Invalid route handler.');
        }

        if ($result instanceof Response) {
            return $result;
        }

        // Wrap string/int in plain response
        return new Response((string) $result);
    }

    /**
     * Run middleware stack; return a Response to short-circuit, or null to continue.
     *
     * @param string[] $stack
     */
    private function runMiddleware(array $stack, Request $request): ?Response
    {
        foreach ($stack as $middlewareClass) {
            if (!class_exists($middlewareClass)) {
                // Try App\Middleware namespace
                $fqn = 'App\\Middleware\\' . $middlewareClass;
                if (!class_exists($fqn)) {
                    throw new \RuntimeException("Middleware [{$middlewareClass}] not found.");
                }
                $middlewareClass = $fqn;
            }

            $result = (new $middlewareClass())->handle($request);

            if ($result instanceof Response) {
                return $result;
            }
        }

        return null;
    }

    private function notFound(): Response
    {
        $response = new Response('<h1>404 – Not Found</h1><p>The page you requested does not exist.</p>', 404);
        return $response;
    }
}

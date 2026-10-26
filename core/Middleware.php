<?php

declare(strict_types=1);

namespace Core;

/**
 * Middleware – base contract all middleware must implement.
 *
 * A middleware's handle() method should either:
 *   - Return null / void to pass control to the next layer.
 *   - Return a Response to short-circuit the pipeline.
 */
interface Middleware
{
    public function handle(Request $request): ?Response;
}

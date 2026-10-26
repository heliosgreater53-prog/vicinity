<?php

declare(strict_types=1);

/**
 * Vicinity – Hyperlocal Community Platform
 * Front Controller
 */

define('VICINITY_START', microtime(true));

$root = dirname(__DIR__);

// 1. Autoload dependencies
if (file_exists($root . '/vendor/autoload.php')) {
    require_once $root . '/vendor/autoload.php';
} else {
    // Fallback PSR-4 autoloader before composer install
    require_once $root . '/core/helpers.php';

    spl_autoload_register(function (string $class) use ($root) {
        $prefixes = [
            'Core\\' => $root . '/core/',
            'App\\'  => $root . '/app/',
        ];

        foreach ($prefixes as $prefix => $baseDir) {
            $len = strlen($prefix);
            if (strncmp($prefix, $class, $len) !== 0) {
                continue;
            }

            $relativeClass = substr($class, $len);
            $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

            if (file_exists($file)) {
                require_once $file;
                return;
            }
        }
    });
}

// 2. Initialize application
$app = Core\Application::getInstance($root);

// 3. Register routes
$router = $app->router;
require_once $root . '/routes/web.php';

// 4. Run application
$app->run();

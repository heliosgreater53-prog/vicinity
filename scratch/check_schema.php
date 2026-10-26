<?php
require __DIR__ . '/../vendor/autoload.php';
// Or require core directly if not autoloaded
require_once __DIR__ . '/../core/Database.php';

// Load .env
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (str_starts_with(trim($line), '#') || !str_contains($line, '=')) continue;
        [$k, $v] = explode('=', $line, 2);
        $_ENV[trim($k)] = trim($v);
    }
}

try {
    require_once __DIR__ . '/../core/helpers.php';
    $pdo = \Core\Database::getInstance()->getPdo();
    $stmt = $pdo->query('DESCRIBE businesses');
    $cols = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "Columns in businesses table:\n";
    foreach ($cols as $col) {
        echo "- " . $col['Field'] . " (" . $col['Type'] . ")\n";
    }
    $cnt = $pdo->query('SELECT COUNT(*) FROM businesses')->fetchColumn();
    echo "Existing businesses: {$cnt}\n";
} catch (\Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

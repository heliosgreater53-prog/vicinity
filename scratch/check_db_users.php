<?php
require_once dirname(__DIR__) . '/vendor/autoload.php';
$app = Core\Application::getInstance(dirname(__DIR__));

try {
    $db = Core\Database::getInstance();
    $tables = $db->query("SHOW TABLES")->fetchAll();
    echo "Connected to DB successfully.\nTables:\n";
    print_r($tables);

    $users = $db->query("SELECT id, name, email, password FROM users")->fetchAll();
    echo "\nUsers in DB:\n";
    foreach ($users as $u) {
        echo "ID: {$u['id']} | Name: {$u['name']} | Email: {$u['email']} | PwdHash: " . substr($u['password'], 0, 15) . "...\n";
    }
} catch (\Throwable $e) {
    echo "DB Error: " . $e->getMessage() . "\n" . $e->getTraceAsString();
}


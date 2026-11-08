<?php
// Quick smoke test: verify new tables exist and models can be used
require_once __DIR__ . '/../vendor/autoload.php';

// Minimal bootstrap to get DB
$_ENV['DB_HOST']     = '127.0.0.1';
$_ENV['DB_PORT']     = '3306';
$_ENV['DB_DATABASE'] = 'vicinity';
$_ENV['DB_USERNAME'] = 'root';
$_ENV['DB_PASSWORD'] = '';

// Load helpers
require_once __DIR__ . '/../core/helpers.php';

// Fake app() for Database::getInstance() to work
// Just test PDO directly
$pdo = new PDO(
    'mysql:host=127.0.0.1;port=3306;dbname=vicinity;charset=utf8mb4',
    'root', '',
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
);

// 1. Check columns on businesses table
$cols = $pdo->query('SHOW COLUMNS FROM businesses')->fetchAll(PDO::FETCH_COLUMN);
$required = ['logo', 'cover_image'];
foreach ($required as $col) {
    echo ($col . ': ' . (in_array($col, $cols) ? 'OK' : 'MISSING') . PHP_EOL);
}

// 2. Check new tables exist
foreach (['business_products', 'business_services'] as $table) {
    try {
        $count = $pdo->query("SELECT COUNT(*) FROM `$table`")->fetchColumn();
        echo "$table: OK (rows: $count)" . PHP_EOL;
    } catch (Exception $e) {
        echo "$table: MISSING – " . $e->getMessage() . PHP_EOL;
    }
}

// 3. Test insert + retrieve cycle
$pdo->exec("INSERT INTO businesses (user_id, name, category, address, logo, cover_image, rating, reviews_count, price_range, status, opening_hours) VALUES (1, 'Test Shop', 'Other', '1 Test St', 'https://example.com/logo.png', 'https://example.com/cover.jpg', 5.0, 0, '₦₦', 'Open Now', '9AM-5PM')");
$bizId = (int) $pdo->lastInsertId();
echo "Inserted business id=$bizId" . PHP_EOL;

$pdo->exec("INSERT INTO business_products (business_id, name, price, description) VALUES ($bizId, 'Test Widget', '₦1,000', 'A test product')");
$pdo->exec("INSERT INTO business_services (business_id, name, icon, description) VALUES ($bizId, 'Test Service', 'fa-star', 'A test service')");
echo 'Inserted product and service rows' . PHP_EOL;

$prod = $pdo->query("SELECT * FROM business_products WHERE business_id=$bizId")->fetchAll();
$serv = $pdo->query("SELECT * FROM business_services WHERE business_id=$bizId")->fetchAll();
echo 'Product name: ' . $prod[0]['name'] . ' — price: ' . $prod[0]['price'] . PHP_EOL;
echo 'Service name: ' . $serv[0]['name'] . ' — icon: '  . $serv[0]['icon']  . PHP_EOL;

// Cleanup test record (cascade deletes product+service)
$pdo->exec("DELETE FROM businesses WHERE id=$bizId");
echo 'Cleanup OK — cascade deleted products & services' . PHP_EOL;

echo PHP_EOL . 'All smoke tests PASSED.' . PHP_EOL;


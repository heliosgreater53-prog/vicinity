<?php
declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');

define('VICINITY_START', microtime(true));

$root = dirname(__DIR__);
require_once $root . '/vendor/autoload.php';
$app = Core\Application::getInstance($root);

echo "=== Step 1: DB Connection ===" . PHP_EOL;
try {
    $db = Core\Database::getInstance();
    $count = $db->query("SELECT COUNT(*) as c FROM users")->fetchOne();
    echo "DB OK — users count: " . $count['c'] . PHP_EOL;
} catch (Throwable $e) {
    echo "DB FAIL: " . $e->getMessage() . PHP_EOL;
    exit;
}

echo PHP_EOL . "=== Step 2: Auth::attempt() ===" . PHP_EOL;

// Try each user in DB
$users = [
    ['alex@vicinity.local', 'password'],
    ['heliosgreater53@gmail.com', 'password'],
    ['testing@example.com', 'password'],
    ['test@example.com', 'password'],
];

foreach ($users as [$email, $pass]) {
    try {
        $result = auth()->attempt($email, $pass);
        echo "attempt({$email}) => " . ($result ? "SUCCESS" : "FAIL (wrong password)") . PHP_EOL;
        if ($result) {
            $userId = auth()->id();
            echo "  Logged in as user_id: {$userId}" . PHP_EOL;
        }
    } catch (Throwable $e) {
        echo "attempt({$email}) => EXCEPTION: " . get_class($e) . ": " . $e->getMessage() . PHP_EOL;
        echo $e->getTraceAsString() . PHP_EOL;
    }
}

echo PHP_EOL . "=== Step 3: Check web server PHP ===" . PHP_EOL;
echo "CLI PHP binary: " . PHP_BINARY . PHP_EOL;
echo "CLI php.ini: " . php_ini_loaded_file() . PHP_EOL;
echo "pdo_mysql loaded (CLI): " . (extension_loaded('pdo_mysql') ? 'YES' : 'NO') . PHP_EOL;

echo PHP_EOL . "=== Step 4: Session test ===" . PHP_EOL;
try {
    $session = app(Core\Session::class);
    $session->set('test_key', 'hello');
    $val = $session->get('test_key');
    echo "Session set/get: " . ($val === 'hello' ? 'OK' : 'FAIL') . PHP_EOL;
    echo "Session save path: " . session_save_path() . PHP_EOL;
    echo "Session status: " . session_status() . " (2=active)" . PHP_EOL;
} catch (Throwable $e) {
    echo "Session FAIL: " . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL . "=== Step 5: Check intended_url / redirect target ===" . PHP_EOL;
$intended = '/home';
echo "After login, redirects to: {$intended}" . PHP_EOL;

echo PHP_EOL . "=== Step 6: Simulate HomeController::index() ===" . PHP_EOL;
try {
    $posts = App\Models\Post::query()->latest()->limit(10)->get();
    echo "Posts query OK — rows: " . count($posts) . PHP_EOL;
} catch (Throwable $e) {
    echo "Posts FAIL: " . get_class($e) . ": " . $e->getMessage() . PHP_EOL;
}

try {
    $events = App\Models\Event::query()->latest('event_date')->limit(3)->get();
    echo "Events query OK — rows: " . count($events) . PHP_EOL;
} catch (Throwable $e) {
    echo "Events FAIL: " . get_class($e) . ": " . $e->getMessage() . PHP_EOL;
}

try {
    $businesses = App\Models\Business::query()->latest()->limit(4)->get();
    echo "Businesses query OK — rows: " . count($businesses) . PHP_EOL;
} catch (Throwable $e) {
    echo "Businesses FAIL: " . get_class($e) . ": " . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL . "Done." . PHP_EOL;


<?php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=vicinity;charset=utf8mb4', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

// Step 1: Add logo column
try {
    $pdo->exec('ALTER TABLE businesses ADD COLUMN logo VARCHAR(500) NULL AFTER image');
    echo 'Added logo column' . PHP_EOL;
} catch (Exception $e) { echo 'logo: ' . $e->getMessage() . PHP_EOL; }

// Step 2: Add cover_image column
try {
    $pdo->exec('ALTER TABLE businesses ADD COLUMN cover_image VARCHAR(500) NULL AFTER logo');
    echo 'Added cover_image column' . PHP_EOL;
} catch (Exception $e) { echo 'cover_image: ' . $e->getMessage() . PHP_EOL; }

// Step 3: Create business_products table
$pdo->exec('CREATE TABLE IF NOT EXISTS `business_products` (
    `id`          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `business_id` INT UNSIGNED NOT NULL,
    `name`        VARCHAR(200) NOT NULL,
    `description` TEXT NULL,
    `price`       VARCHAR(100) NULL,
    `created_at`  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_bp_business` FOREIGN KEY (`business_id`) REFERENCES `businesses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci');
echo 'Created business_products table' . PHP_EOL;

// Step 4: Create business_services table
$pdo->exec('CREATE TABLE IF NOT EXISTS `business_services` (
    `id`          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `business_id` INT UNSIGNED NOT NULL,
    `name`        VARCHAR(200) NOT NULL,
    `description` TEXT NULL,
    `icon`        VARCHAR(100) NULL DEFAULT "fa-circle-check",
    `created_at`  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_bs_business` FOREIGN KEY (`business_id`) REFERENCES `businesses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci');
echo 'Created business_services table' . PHP_EOL;

echo 'Migration complete!' . PHP_EOL;


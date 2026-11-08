<?php
/**
 * Migration: Add post routing columns to posts table
 *
 * - feed         ENUM('main','group') DEFAULT 'main'
 *                'main'  → appears only in the main community/home feed
 *                'group' → appears only in a specific group's feed
 *
 * - community_id INT UNSIGNED NULL (FK → communities.id ON DELETE SET NULL)
 *                NULL when feed = 'main'
 *                Set to the target group's id when feed = 'group'
 *
 * Existing posts (pre-migration) have both columns as NULL / default,
 * so they will keep appearing in the main feed via the NULL-safe WHERE.
 */

$pdo = new PDO(
    'mysql:host=127.0.0.1;port=3306;dbname=vicinity;charset=utf8mb4',
    'root',
    '',
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

// Step 1 — add `feed` column
try {
    $pdo->exec(
        "ALTER TABLE `posts`
         ADD COLUMN `feed` ENUM('main','group') NOT NULL DEFAULT 'main'
         AFTER `comments_count`"
    );
    echo "Added column: posts.feed\n";
} catch (Exception $e) {
    echo "posts.feed: " . $e->getMessage() . "\n";
}

// Step 2 — add `community_id` column
try {
    $pdo->exec(
        "ALTER TABLE `posts`
         ADD COLUMN `community_id` INT UNSIGNED NULL DEFAULT NULL
         AFTER `feed`"
    );
    echo "Added column: posts.community_id\n";
} catch (Exception $e) {
    echo "posts.community_id: " . $e->getMessage() . "\n";
}

// Step 3 — add FK (soft — ON DELETE SET NULL so deleting a group doesn't nuke posts)
try {
    $pdo->exec(
        "ALTER TABLE `posts`
         ADD CONSTRAINT `fk_posts_community`
         FOREIGN KEY (`community_id`) REFERENCES `communities` (`id`)
         ON DELETE SET NULL"
    );
    echo "Added FK: fk_posts_community\n";
} catch (Exception $e) {
    echo "FK: " . $e->getMessage() . "\n";
}

// Step 4 — index for fast filtering
try {
    $pdo->exec("ALTER TABLE `posts` ADD INDEX `idx_posts_feed` (`feed`)");
    echo "Added index: idx_posts_feed\n";
} catch (Exception $e) {
    echo "index: " . $e->getMessage() . "\n";
}

try {
    $pdo->exec("ALTER TABLE `posts` ADD INDEX `idx_posts_community_id` (`community_id`)");
    echo "Added index: idx_posts_community_id\n";
} catch (Exception $e) {
    echo "index: " . $e->getMessage() . "\n";
}

echo "\nMigration complete!\n";


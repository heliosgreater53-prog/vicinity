<?php
/**
 * Migration: Add group chat tables
 * - users.last_seen_at       (online presence)
 * - community_members        (membership + roles)
 * - community_messages       (group chatroom)
 */

$pdo = new PDO(
    'mysql:host=127.0.0.1;port=3306;dbname=vicinity;charset=utf8mb4',
    'root', '',
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

// 1. Add last_seen_at to users
try {
    $pdo->exec("ALTER TABLE `users` ADD COLUMN `last_seen_at` DATETIME NULL DEFAULT NULL AFTER `location`");
    echo "Added column: users.last_seen_at\n";
} catch (Exception $e) { echo "users.last_seen_at: " . $e->getMessage() . "\n"; }

// 2. community_members table
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS `community_members` (
        `id`           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `community_id` INT UNSIGNED NOT NULL,
        `user_id`      INT UNSIGNED NOT NULL,
        `role`         ENUM('admin','moderator','member') NOT NULL DEFAULT 'member',
        `joined_at`    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY `uq_cm` (`community_id`, `user_id`),
        INDEX `idx_cm_community` (`community_id`),
        INDEX `idx_cm_user` (`user_id`),
        CONSTRAINT `fk_cm_community` FOREIGN KEY (`community_id`) REFERENCES `communities` (`id`) ON DELETE CASCADE,
        CONSTRAINT `fk_cm_user`      FOREIGN KEY (`user_id`)      REFERENCES `users` (`id`)      ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "Created table: community_members\n";
} catch (Exception $e) { echo "community_members: " . $e->getMessage() . "\n"; }

// 3. community_messages table
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS `community_messages` (
        `id`           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `community_id` INT UNSIGNED NOT NULL,
        `user_id`      INT UNSIGNED NOT NULL,
        `message`      TEXT NOT NULL,
        `created_at`   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        INDEX `idx_cmsg_community_id` (`community_id`, `id`),
        CONSTRAINT `fk_cmsg_community` FOREIGN KEY (`community_id`) REFERENCES `communities` (`id`) ON DELETE CASCADE,
        CONSTRAINT `fk_cmsg_user`      FOREIGN KEY (`user_id`)      REFERENCES `users` (`id`)      ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "Created table: community_messages\n";
} catch (Exception $e) { echo "community_messages: " . $e->getMessage() . "\n"; }

// 4. Seed existing community creators as admins
try {
    $pdo->exec("INSERT IGNORE INTO `community_members` (`community_id`, `user_id`, `role`, `joined_at`)
                SELECT `id`, `user_id`, 'admin', `created_at` FROM `communities`");
    echo "Seeded existing community creators as admin members\n";
} catch (Exception $e) { echo "seed: " . $e->getMessage() . "\n"; }

echo "\nMigration complete!\n";

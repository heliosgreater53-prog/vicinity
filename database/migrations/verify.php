<?php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=vicinity;charset=utf8mb4', 'root', '');
$checks = [
    'community_members table'  => "SHOW TABLES LIKE 'community_members'",
    'community_messages table' => "SHOW TABLES LIKE 'community_messages'",
    'users.last_seen_at'       => "SHOW COLUMNS FROM users LIKE 'last_seen_at'",
    'posts.feed column'        => "SHOW COLUMNS FROM posts LIKE 'feed'",
    'posts.community_id'       => "SHOW COLUMNS FROM posts LIKE 'community_id'",
];
foreach ($checks as $label => $sql) {
    $row = $pdo->query($sql)->fetch();
    echo ($row ? '  PASS' : '  FAIL') . ': ' . $label . PHP_EOL;
}

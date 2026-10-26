<?php

$urls = [
    'http://127.0.0.1:8000/businesses',
    'http://127.0.0.1:8000/businesses/1',
    'http://127.0.0.1:8000/businesses/2',
    'http://127.0.0.1:8000/businesses/3',
    'http://127.0.0.1:8000/businesses/4',
    'http://127.0.0.1:8000/businesses/5',
    'http://127.0.0.1:8000/businesses/6',
];

foreach ($urls as $url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $html = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    echo "=== URL: {$url} (Status: {$code}) ===\n";
    if (preg_match('/<title>(.*?)<\/title>/', $html, $m)) {
        echo "Title: " . trim($m[1]) . "\n";
    }
    if (preg_match('/<section class="business-hero">.*?<h1>(.*?)<\/h1>/s', $html, $m)) {
        echo "H1 Hero: " . trim($m[1]) . "\n";
    }
    if (preg_match('/<span class="detail-badge">(.*?)<\/span>/', $html, $m)) {
        echo "Category: " . trim($m[1]) . "\n";
    }
    if (preg_match('/<div class="menu-grid">(.*?)<\/div>/s', $html, $m)) {
        preg_match_all('/<span class="menu-name">(.*?)<\/span>\s*<span class="menu-price">(.*?)<\/span>/', $m[1], $items, PREG_SET_ORDER);
        echo "Menu/Items found: " . count($items) . "\n";
        foreach (array_slice($items, 0, 3) as $it) {
            echo "  - " . trim($it[1]) . ": " . trim($it[2]) . "\n";
        }
    }
    if (preg_match('/<div class="services-list">(.*?)<\/div>/s', $html, $m)) {
        preg_match_all('/<div class="service-item">.*?<span>(.*?)<\/span>/s', $m[1], $items);
        echo "Services found: " . count($items[1]) . " (" . implode(', ', array_slice($items[1], 0, 3)) . "...)\n";
    }
    echo "\n";
}

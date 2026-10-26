<?php

// More thorough check — count all menu-item and service-item divs per page
$urls = [
    '/businesses'   => 'Directory index',
    '/businesses/1' => 'GreenBite Cafe',
    '/businesses/2' => 'Surulere TechFix',
    '/businesses/3' => 'Apex Fresh Supermarket',
    '/businesses/4' => 'Royal Touch Spa',
    '/businesses/5' => 'Urban Thread Bespoke',
    '/businesses/6' => 'Zenith Fitness Hub',
];

$baseUrl = 'http://127.0.0.1:8000';

foreach ($urls as $path => $label) {
    $ch = curl_init($baseUrl . $path);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $html  = curl_exec($ch);
    $code  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    preg_match('/<title>(.*?)<\/title>/s', $html, $tm);
    $menuCount    = preg_match_all('/class="menu-item"/', $html);
    $serviceCount = preg_match_all('/class="service-item"/', $html);
    $hourCount    = preg_match_all('/class="hour-item"/', $html);

    echo "[$code] {$label} ({$path})\n";
    echo "  Title      : " . trim($tm[1] ?? '—') . "\n";
    echo "  menu-items : {$menuCount}, service-items: {$serviceCount}, hour-items: {$hourCount}\n";
    echo "\n";
}

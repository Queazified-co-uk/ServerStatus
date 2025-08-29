<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

$servers = [
    ['name' => 'Velocity Proxy', 'host' => 'join.queazified.co.uk', 'port' => 25565],
    ['name' => 'Paper Server',  'host' => '127.0.0.1',               'port' => 25565],
    ['name' => 'Purpur Server', 'host' => '127.0.0.1',               'port' => 25566],
];

function probeServer(string $host, int $port, float $timeout = 2.0): array {
    $start = microtime(true);
    $errno = 0; $errstr = '';
    $conn = @fsockopen($host, $port, $errno, $errstr, $timeout);
    $elapsed = (int) round((microtime(true) - $start) * 1000); // ms
    if ($conn) {
        fclose($conn);
        return ['online' => true, 'ping' => $elapsed];
    }
    return ['online' => false, 'ping' => null];
}

$result = [];
foreach ($servers as $s) {
    $probe = probeServer($s['host'], $s['port'], 2.0);
    $result[] = [
        'name'       => $s['name'],
        'host'       => $s['host'],
        'port'       => $s['port'],
        'status'     => $probe['online'] ? 'online' : 'offline',
        'ping_ms'    => $probe['ping'],
        'checked_at' => gmdate('c'),
    ];
}

echo json_encode($result, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);

<?php
header('Content-Type: application/json');
$servers = [
    ['name' => 'Velocity Proxy', 'host' => 'join.queazified.co.uk', 'port' => 25565],
    ['name' => 'Paper Server', 'host' => '127.0.0.1', 'port' => 25565],
    ['name' => 'Purpur Server', 'host' => '127.0.0.1', 'port' => 25566],
    // ...add more servers as needed...
];
function isServerOnline($host, $port, $timeout = 2) {
    $conn = @fsockopen($host, $port, $errno, $errstr, $timeout);
    if ($conn) {
        fclose($conn);
        return true;
    }
    return false;
}
$result = [];
foreach ($servers as $srv) {
    $srv['status'] = isServerOnline($srv['host'], $srv['port']) ? 'online' : 'offline';
    $result[] = $srv;
}
echo json_encode($result);

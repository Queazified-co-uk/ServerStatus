<?php
// Redirect to the static HTML status page
header('Location: status.html', true, 302);
exit;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Minecraft Server Status</title>
    <style>
        body { font-family: Arial, sans-serif; background: #222; color: #eee; }
        table { margin: 2em auto; border-collapse: collapse; }
        th, td { padding: 0.7em 1.2em; border: 1px solid #444; }
        th { background: #333; }
        .online { color: #4CAF50; font-weight: bold; }
        .offline { color: #F44336; font-weight: bold; }
    </style>
</head>
<body>
    <h1 style="text-align:center;">Minecraft Server Status</h1>
    <table>
        <tr>
            <th>Server</th>
            <th>Address</th>
            <th>Status</th>
        </tr>
        <?php
        // Define your servers here
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

        foreach ($servers as $srv) {
            $online = isServerOnline($srv['host'], $srv['port']) ? 'online' : 'offline';
            echo "<tr>
                <td>{$srv['name']}</td>
                <td>{$srv['host']}:{$srv['port']}</td>
                <td class='$online'>" . ucfirst($online) . "</td>
            </tr>";
        }
        ?>
    </table>
</body>
</html>

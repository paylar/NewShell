<?php
// db_api.php
// Menerima POST => key, ip
// Generate port random, tulis ke multi_reverse_db.csv
// Kembalikan JSON: {status, key, ip, port}

header('Content-Type: application/json');

$db_file = __DIR__ . '/multi_reverse_db.csv';
if (!file_exists($db_file)) {
    touch($db_file);
}

$key = isset($_POST['key']) ? trim($_POST['key']) : '';
$ip  = isset($_POST['ip'])  ? trim($_POST['ip'])  : '';

if ($key === '') {
    echo json_encode([
        'status'  => 'error',
        'message' => 'Missing key'
    ]);
    exit;
}

// Generate random port
$port_min = 30000;
$port_max = 40000;
$port = rand($port_min, $port_max);

// Tulis ke CSV
$date = date('Y-m-d H:i:s');
$line = "$key,$ip,$port,STOPPED,-,$date\n";
file_put_contents($db_file, $line, FILE_APPEND);

// Kembalikan respons
echo json_encode([
    'status' => 'success',
    'key'    => $key,
    'ip'     => $ip,
    'port'   => $port
]);

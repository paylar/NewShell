<?php
// db_api.php
// Contoh API untuk menerima key, ip, lalu menghasilkan port acak, dan mengembalikan data JSON.

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

// Generate port random
$port_min = 30000;
$port_max = 40000;
$port = rand($port_min, $port_max);

// Tulis data ke file CSV (API side). 
// Di sini hanya untuk referensi, nantinya script.sh juga akan menulis ke local DB.
$date = date('Y-m-d H:i:s');
$line = "$key,$ip,$port,API_STORED,-,$date\n";
file_put_contents($db_file, $line, FILE_APPEND);

// Respons JSON
echo json_encode([
    'status' => 'success',
    'key'    => $key,
    'ip'     => $ip,
    'port'   => $port
]);

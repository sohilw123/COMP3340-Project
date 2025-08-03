<?php
header('Content-Type: application/json; charset=utf-8');
ini_set('display_errors', 1);
error_reporting(E_ALL);

$host = 'localhost';
$user = 'globetro_sohilw';
$password = 'testing@#$';
$dbname = 'globetro_products';

$conn = new mysqli($host, $user, $password, $dbname);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => $conn->connect_error]);
    exit;
}

$sql = "SELECT * FROM product_variants WHERE product_id = 1";
$result = $conn->query($sql);
if (!$result) {
    echo json_encode(["status" => "error", "message" => $conn->error]);
    exit;
}

$variants = [];
while ($row = $result->fetch_assoc()) {
    // Clean all strings in the row
    foreach ($row as $key => $value) {
        if (is_string($value)) {
            $row[$key] = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
        }
    }
    $variants[] = $row;
}

$conn->close();

// Check for JSON errors
$json = json_encode([
    "status" => "success",
    "count" => count($variants),
    "data" => $variants
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

if ($json === false) {
    echo json_encode([
        "status" => "error",
        "message" => "json_encode failed",
        "error" => json_last_error_msg()
    ]);
    exit;
}

echo $json;
?>
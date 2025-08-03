<?php
// Set response headers
header('Content-Type: application/json');

// Database connection settings
$host = 'localhost';        // or your DB host
$username = 'globetro_sohilw';
$password = 'testing@#$';
$database = 'globetro_products';

// Attempt connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Connection failed: ' . $conn->connect_error
    ]);
    exit;
}

echo json_encode([
    'status' => 'success',
    'message' => 'Database connection successful!'
]);

$conn->close();
?>

<?php
header('Content-Type: application/json');

$host = 'localhost';
$dbname = 'globetro_products';
$user = 'globetro_sohilw';
$pass = 'testing@#$';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed"]);
    exit();
}

$sql = "SELECT username, email, password, isAdmin FROM users";
$result = $conn->query($sql);

$users = [];

while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

echo json_encode($users);
$conn->close();
?>

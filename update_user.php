<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "globetro_sohilw", "testing@#$", "globetro_products");
if ($conn->connect_error) {
  http_response_code(500);
  echo json_encode(["status" => "error", "message" => $conn->connect_error]);
  exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$username = $data['username'];
$isAdmin = $data['isAdmin'];

$stmt = $conn->prepare("UPDATE users SET isAdmin = ? WHERE username = ?");
$stmt->bind_param("is", $isAdmin, $username);

if ($stmt->execute()) {
  echo json_encode(["status" => "success"]);
} else {
  http_response_code(500);
  echo json_encode(["status" => "error", "message" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>

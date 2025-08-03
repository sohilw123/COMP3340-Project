<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "globetro_sohilw", "testing@#$", "globetro_products");
if ($conn->connect_error) {
  http_response_code(500);
  echo json_encode(["status" => "error", "message" => $conn->connect_error]);
  exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'];
$name = $data['name'];
$category = $data['category'];
$description = $data['description'];

$stmt = $conn->prepare("UPDATE products SET name=?, category=?, description=? WHERE id=?");
$stmt->bind_param("sssi", $name, $category, $description, $id);

if ($stmt->execute()) {
  echo json_encode(["status" => "success"]);
} else {
  http_response_code(500);
  echo json_encode(["status" => "error", "message" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>

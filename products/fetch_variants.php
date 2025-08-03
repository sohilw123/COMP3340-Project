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

$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;
if ($product_id <= 0) {
    echo json_encode(["status" => "error", "message" => "Invalid product_id"]);
    exit;
}

$sql = "SELECT variant_name, price, description, review1, review2, image FROM product_variants WHERE product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

$variants = [];
while ($row = $result->fetch_assoc()) {
    if (
        !isset($row['variant_name'], $row['price'], $row['description'], $row['review1'], $row['review2'], $row['image'])
    ) continue;

    $variants[] = [
        "variant_name" => $row["variant_name"],
        "price" => $row["price"],
        "description" => $row["description"],
        "image" => $row["image"],
        "reviews" => [$row["review1"], $row["review2"]]
    ];
}

$stmt->close();
$conn->close();

echo json_encode([
    "status" => "success",
    "count" => count($variants),
    "data" => $variants
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
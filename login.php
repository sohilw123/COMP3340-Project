<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

// DB connection
$host = 'localhost';
$dbname = 'globetro_products';
$user = 'globetro_sohilw';
$pass = 'testing@#$';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Get POST data
$username = trim($_POST['username']);
$password = $_POST['password'];

// Find user by username
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    
    if (password_verify($password, $user['password'])) {
        // Password is correct — start session
        $_SESSION['username'] = $user['username'];
        $_SESSION['isAdmin'] = $user['isAdmin'];
        $_SESSION['email'] = $user['email'];

        // Redirect to dashboard or homepage
        header("Location: homepage.html"); // Change this to your actual homepage
        exit();
    } else {
        echo "Invalid password.";
    }
} else {
    echo "User not found.";
}

$stmt->close();
$conn->close();
?>

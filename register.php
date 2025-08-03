<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// DB credentials
$host = 'localhost';
$dbname = 'globetro_products';
$user = 'globetro_sohilw';
$pass = 'testing@#$';

// Connect to database
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST data
$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Basic validation
if ($password !== $confirm_password) {
    die("Passwords do not match.");
}

// Check if username or email already exists
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
$stmt->bind_param("ss", $username, $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    die("Username or email already exists.");
}
$stmt->close();

// Hash password WIP
$hashed_password = $password; // Store as plain text (not secure)

// Insert user
$stmt = $conn->prepare("INSERT INTO users (username, password, email, isAdmin) VALUES (?, ?, ?, 0)");
$stmt->bind_param("sss", $username, $hashed_password, $email);

if ($stmt->execute()) {
    echo "Registration successful. <a href='login.html'>Login here</a>.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

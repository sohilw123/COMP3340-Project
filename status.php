<?php
header('Content-Type: application/json');

$services = [
  "Homepage" => "http://globetrottersw.ca/",
  "User Auth Service" => "http://globetrottersw.ca/HTML/auth.js",
  "Database Ping" => "http://globetrottersw.ca/HTML/ping_db.php"
];

function checkStatus($url) {
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_TIMEOUT, 5);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_NOBODY, true);
  curl_exec($ch);
  $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);
  return ($httpCode >= 200 && $httpCode < 400);
}

$response = [];
foreach ($services as $name => $url) {
  $response[] = [
    "name" => $name,
    "url" => $url,
    "status" => checkStatus($url) ? "online" : "offline"
  ];
}

echo json_encode($response);
?>
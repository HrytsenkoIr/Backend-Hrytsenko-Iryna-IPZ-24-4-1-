<?php
require "db.php";

$data = json_decode(file_get_contents("php://input"), true);

$name = trim($data["name"] ?? "");
$email = trim($data["email"] ?? "");
$password = trim($data["password"] ?? "");

if (!$name) {
    echo json_encode(["error" => "Name is empty"]);
    exit;
}

if (!$email) {
    echo json_encode(["error" => "Email is empty"]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["error" => "Invalid email"]);
    exit;
}

if (!$password) {
    echo json_encode(["error" => "Password is empty"]);
    exit;
}

if (strlen($password) < 6) {
    echo json_encode(["error" => "Password must be at least 6 characters"]);
    exit;
}

$stmt = $pdo->prepare("SELECT id FROM users WHERE email=?");
$stmt->execute([$email]);

if ($stmt->rowCount() > 0) {
    echo json_encode(["error" => "Email already exists"]);
    exit;
}

$pass = password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO users(name,email,password) VALUES(?,?,?)");
$stmt->execute([$name, $email, $pass]);

echo json_encode(["success" => true]);
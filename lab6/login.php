<?php
require "db.php";

$data = json_decode(file_get_contents("php://input"), true);

$email = trim($data["email"] ?? "");
$password = trim($data["password"] ?? "");

if (!$email) {
    echo json_encode(["error" => "Email is empty"]);
    exit;
}

if (!$password) {
    echo json_encode(["error" => "Password is empty"]);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE email=?");
$stmt->execute([$email]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo json_encode(["error" => "User not found"]);
    exit;
}

if (!password_verify($password, $user["password"])) {
    echo json_encode(["error" => "Wrong password"]);
    exit;
}

echo json_encode(["success" => true]);
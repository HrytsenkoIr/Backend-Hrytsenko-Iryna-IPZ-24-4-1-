<?php
require "db.php";

$method = $_SERVER["REQUEST_METHOD"];

if ($method == "GET") {
    $stmt = $pdo->query("SELECT * FROM notes");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

if ($method == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    $title = trim($data["title"] ?? "");
    $content = trim($data["content"] ?? "");

    if (!$title) {
        echo json_encode(["error" => "Title is empty"]);
        exit;
    }

    if (!$content) {
        echo json_encode(["error" => "Content is empty"]);
        exit;
    }

    $stmt = $pdo->prepare("INSERT INTO notes(title,content) VALUES(?,?)");
    $stmt->execute([$title, $content]);

    echo json_encode(["success" => true]);
}

if ($method == "DELETE") {
    $data = json_decode(file_get_contents("php://input"), true);

    $id = $data["id"];

    $stmt = $pdo->prepare("DELETE FROM notes WHERE id=?");
    $stmt->execute([$id]);

    echo json_encode(["success" => true]);
}

if ($method == "PUT") {
    $data = json_decode(file_get_contents("php://input"), true);

    $id = $data["id"];
    $title = trim($data["title"] ?? "");
    $content = trim($data["content"] ?? "");

    if (!$title || !$content) {
        echo json_encode(["error" => "Title and content are required"]);
        exit;
    }

    $stmt = $pdo->prepare("UPDATE notes SET title=?, content=? WHERE id=?");
    $stmt->execute([$title, $content, $id]);

    echo json_encode(["success" => true]);
}
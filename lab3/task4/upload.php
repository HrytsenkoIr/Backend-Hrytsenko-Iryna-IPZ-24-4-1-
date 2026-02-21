<?php

$targetDir = "uploads/";

if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $file = $_FILES['image'];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        die("Помилка завантаження файлу. Код: " . $file['error']);
    }

    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($file['type'], $allowedTypes)) {
        die("Дозволені лише формати JPG, PNG, GIF.");
    }

    $fileName = basename($file['name']);
    $targetFilePath = $targetDir . time() . '_' . $fileName;

    if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
        echo "Файл успішно збережено: " . $targetFilePath;
    } else {
        echo "Помилка при збереженні файлу.";
    }
} else {
    echo "Форму не було надіслано.";
}

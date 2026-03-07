<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=company_db;charset=utf8', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Помилка підключення до company_db: " . $e->getMessage();
}
?>
<?php
session_start();
require_once '../db.php';
if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    session_destroy();
}
header("Location: index.php");
?>
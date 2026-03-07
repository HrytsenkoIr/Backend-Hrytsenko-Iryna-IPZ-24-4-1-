<?php
session_start();
require_once '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: index.php");
    } else {
        echo "Невірний логін або пароль";
    }
}
?>
<form method="POST">
    <input type="text" name="username" placeholder="Логін" required>
    <input type="password" name="password" placeholder="Пароль" required>
    <button type="submit">Увійти</button>
</form>
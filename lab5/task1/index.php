<?php
session_start();
require_once '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$_POST['username']]);
    $user = $stmt->fetch();

    if ($user && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: index.php");
        exit;
    } else {
        $error = "Невірний логін або пароль!";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Головна</title></head>
<body>
<h1>Вітаємо на нашому сайті</h1>

<?php if (isset($_SESSION['user_id'])): ?>
    <p>Привіт, <b><?= $_SESSION['username'] ?></b>! Ви успішно увійшли.</p>
    <a href="profile.php">Редагувати профіль</a> |
    <a href="logout.php">Вийти</a> |
    <a href="delete.php" onclick="return confirm('Ви впевнені?')">Видалити профіль</a>
<?php else: ?>
    <h3>Вхід</h3>
    <?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>
    <form method="POST">
        Логін: <input type="text" name="username" required><br>
        Пароль: <input type="password" name="password" required><br>
        <button type="submit" name="login">Увійти</button>
    </form>
    <p>Ще не зареєстровані? <a href="register.php">Реєстрація</a></p>
<?php endif; ?>

</body>
</html>
<?php
session_start();
require_once '../db.php';
if (!isset($_SESSION['user_id'])) header("Location: index.php");

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $full_name = $_POST['full_name'];
    $occupation = $_POST['occupation'];
    $phone = $_POST['phone'];
    $age = $_POST['age'];
    $city = $_POST['city'];
    $gender = $_POST['gender'];
    $bio = $_POST['bio'];

    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET username = ?, password = ?, email = ?, full_name = ?, occupation = ?, phone = ?, age = ?, city = ?, gender = ?, bio = ? WHERE id = ?");
        $stmt->execute([$username, $password, $email, $full_name, $occupation, $phone, $age, $city, $gender, $bio, $user_id]);
    } else {
        $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ?, full_name = ?, occupation = ?, phone = ?, age = ?, city = ?, gender = ?, bio = ? WHERE id = ?");
        $stmt->execute([$username, $email, $full_name, $occupation, $phone, $age, $city, $gender, $bio, $user_id]);
    }
    echo "Дані оновлено!";
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
?>

<form method="POST">
    Логін: <input type="text" name="username" value="<?= $user['username'] ?? '' ?>"><br>
    Новий пароль (залиште пустим, якщо не хочете змінювати): <input type="password" name="password"><br>
    Email: <input type="email" name="email" value="<?= $user['email'] ?? '' ?>"><br>
    Повне ім'я: <input type="text" name="full_name" value="<?= $user['full_name'] ?? '' ?>"><br>
    Професія: <input type="text" name="occupation" value="<?= $user['occupation'] ?? '' ?>"><br>
    Телефон: <input type="text" name="phone" value="<?= $user['phone'] ?? '' ?>"><br>
    Вік: <input type="number" name="age" value="<?= $user['age'] ?? '' ?>"><br>
    Місто: <input type="text" name="city" value="<?= $user['city'] ?? '' ?>"><br>
    Стать: <input type="text" name="gender" value="<?= $user['gender'] ?? '' ?>"><br>
    Про себе: <textarea name="bio"><?= $user['bio'] ?? '' ?></textarea><br>
    <button type="submit">Зберегти</button>
</form>
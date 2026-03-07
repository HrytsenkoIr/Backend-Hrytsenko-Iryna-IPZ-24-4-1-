<?php
require_once '../db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $age = $_POST['age'];
    $city = $_POST['city'];
    $gender = $_POST['gender'];
    $bio = $_POST['bio'];
    $full_name = $_POST['full_name'];
    $occupation = $_POST['occupation'];

    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);

    if ($stmt->fetch()) {
        echo "Користувач вже існує!";
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (username, password, email, phone, age, city, gender, bio, full_name, occupation) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$username, $password, $email, $phone, $age, $city, $gender, $bio, $full_name, $occupation]);
        echo "Реєстрація успішна! <a href='index.php'>Увійти</a>";
    }
}
?>
<form method="POST">
    <input type="text" name="username" placeholder="Логін" required><br>
    <input type="password" name="password" placeholder="Пароль" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="text" name="full_name" placeholder="Повне ім'я"><br>
    <input type="text" name="occupation" placeholder="Професія/Діяльність"><br>
    <input type="text" name="phone" placeholder="Телефон"><br>
    <input type="number" name="age" placeholder="Вік"><br>
    <input type="text" name="city" placeholder="Місто"><br>
    <input type="text" name="gender" placeholder="Стать"><br>
    <textarea name="bio" placeholder="Про себе"></textarea><br>
    <button type="submit">Зареєструватися</button>
</form>
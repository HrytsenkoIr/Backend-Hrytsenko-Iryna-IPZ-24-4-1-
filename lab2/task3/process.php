<?php
session_start();

$_SESSION['data'] = $_POST;

$photoPath = '';
if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) mkdir($uploadDir);
    $photoPath = $uploadDir . basename($_FILES['photo']['name']);
    move_uploaded_file($_FILES['photo']['tmp_name'], $photoPath);
}
?>

<!DOCTYPE html>
<html>
<body>
<p>Логін: <?php echo $_POST['login'] ?? ''; ?></p>
<p>Пароль: <?php echo $_POST['pass'] ?? ''; ?></p>
<p>Пароль (ще раз): <?php echo $_POST['pass2'] ?? ''; ?></p>
<p>Стать: <?php echo $_POST['sex'] ?? 'не вибрано'; ?></p>
<p>Місто: <?php echo $_POST['city'] ?? ''; ?></p>
<p>Улюблені ігри: <?php echo isset($_POST['games']) ? implode(', ', $_POST['games']) : 'не вибрано'; ?></p>
<p>Про себе: <?php echo nl2br($_POST['about'] ?? ''); ?></p>

<?php if ($photoPath): ?>
    <p>Фотографія:</p>
    <img src="<?php echo $photoPath; ?>" style="max-width: 200px;">
<?php endif; ?>

<br><br>
<a href="index.php">Повернутися на головну сторінку</a>
</body>
</html>
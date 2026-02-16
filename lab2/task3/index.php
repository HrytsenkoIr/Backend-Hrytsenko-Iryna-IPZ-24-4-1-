<?php
// Завдання 3. Робота з формою. Реалізація форми реєстрації з вибором мови (через кукі),
// збереженням даних у сесії та відображенням результатів.
session_start();

$langMap = [
        'ukr' => 'Українська',
        'eng' => 'English',
        'pol' => 'Polski',
        'deu' => 'Deutsch'
];

if (isset($_GET['lang']) && array_key_exists($_GET['lang'], $langMap)) {
    setcookie('lang', $_GET['lang'], time() + (6 * 30 * 24 * 60 * 60));
    header("Location: index.php");
    exit;
}

$langKey = $_COOKIE['lang'] ?? 'ukr';
$langName = $langMap[$langKey] ?? 'Українська';

$data = $_SESSION['data'] ?? [];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Форма</title>
</head>
<body>

<p>Вибрана мова: <?php echo $langName; ?></p>
<div>
    <a href="index.php?lang=ukr">🇺🇦</a>
    <a href="index.php?lang=eng">🇬🇧</a>
    <a href="index.php?lang=pol">🇵🇱</a>
    <a href="index.php?lang=deu">🇩🇪</a>
</div>

<form action="process.php" method="post" enctype="multipart/form-data">
    Логін: <input type="text" name="login" value="<?php echo $data['login'] ?? ''; ?>"><br>

    Пароль: <input type="password" name="pass" value="<?php echo $data['pass'] ?? ''; ?>"><br>

    Пароль (ще раз): <input type="password" name="pass2" value="<?php echo $data['pass2'] ?? ''; ?>"><br>

    Стать:
    <input type="radio" name="sex" value="чоловік" <?php echo (isset($data['sex']) && $data['sex'] == 'чоловік') ? 'checked' : ''; ?>> чоловік
    <input type="radio" name="sex" value="жінка" <?php echo (isset($data['sex']) && $data['sex'] == 'жінка') ? 'checked' : ''; ?>> жінка<br>

    Місто:
    <select name="city">
        <?php
        $cities = ["Житомир", "Київ", "Львів", "Харків"];
        foreach ($cities as $c) {
            $sel = (isset($data['city']) && $data['city'] == $c) ? 'selected' : '';
            echo "<option value='$c' $sel>$c</option>";
        }
        ?>
    </select><br>

    Улюблені ігри:<br>
    <?php
    $games = ["Genshin", "Dota 2", "CS"];
    $savedGames = $data['games'] ?? [];
    foreach ($games as $g) {
        $ch = (in_array($g, $savedGames)) ? 'checked' : '';
        echo "<input type='checkbox' name='games[]' value='$g' $ch> $g<br>";
    }
    ?>

    Про себе: <br>
    <textarea name="about"><?php echo $data['about'] ?? ''; ?></textarea><br>

    Фотографія: <input type="file" name="photo"><br>

    <button type="submit">Зареєструватися</button>
</form>
</body>
</html>
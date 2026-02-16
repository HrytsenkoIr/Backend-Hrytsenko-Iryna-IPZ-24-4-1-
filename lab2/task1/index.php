<?php
// Завдання 1. Робота з рядками (5 завдань). Включає заміну символів, сортування міст, виділення імені файлу,
// обчислення різниці між датами та генерацію/перевірку паролів.
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Лабораторна 2 - Завдання 1</title>
</head>
<body>

<h3>1. Заміна символів</h3>
<form method="post">
    Текст: <input type="text" name="text" value="<?php echo $_POST['text'] ?? ''; ?>"><br>
    Знайти: <input type="text" name="find" value="<?php echo $_POST['find'] ?? ''; ?>"><br>
    Замінити: <input type="text" name="replace" value="<?php echo $_POST['replace'] ?? ''; ?>"><br>
    Результат: <input type="text" value="<?php echo isset($_POST['text']) ? str_replace($_POST['find'], $_POST['replace'], $_POST['text']) : ''; ?>"><br>
    <button type="submit" name="task1">Виконати</button>
</form>

<h3>2. Сортування міст</h3>
<form method="post">
    Міста (через пробіл): <input type="text" name="cities" value="<?php echo $_POST['cities'] ?? ''; ?>"><br>
    Результат міст: <?php
    if (isset($_POST['task2'])) {
        $arr = explode(' ', trim($_POST['cities']));
        sort($arr);
        echo implode(' ', $arr);
    }
    ?><br>
    <button type="submit" name="task2">Сортувати</button>
</form>

<h3>3. Ім'я файлу</h3>
<?php
$path = "D:\\WebServers\\home\\testsite\\www\\myfile.txt";
$filename = pathinfo($path, PATHINFO_FILENAME);
echo "Повний шлях: $path <br> Ім'я файлу: $filename";
?>

<h3>4. Різниця між датами</h3>
<form method="post">
    Дата 1: <input type="date" name="date1" value="<?php echo $_POST['date1'] ?? ''; ?>"><br>
    Дата 2: <input type="date" name="date2" value="<?php echo $_POST['date2'] ?? ''; ?>"><br>
    Різниця: <?php
    if (isset($_POST['task4'])) {
        $d1 = new DateTime($_POST['date1']);
        $d2 = new DateTime($_POST['date2']);
        echo $d1->diff($d2)->days . " днів";
    }
    ?><br>
    <button type="submit" name="task4">Обчислити</button>
</form>

<h3>5. Паролі</h3>
<form method="post">
    Довжина пароля: <input type="number" name="len" value="10"><br>
    <button type="submit" name="gen_pass">Згенерувати</button>
    <?php
    if (isset($_POST['gen_pass'])) {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*';
        $pass = substr(str_shuffle($chars), 0, $_POST['len']);
        echo "<br>Ваш пароль: $pass";
    }
    ?>
</form>

<form method="post">
    Перевірка міцності пароля: <input type="text" name="check_pass">
    <button type="submit" name="val_pass">Перевірити</button>
    <?php
    if (isset($_POST['val_pass'])) {
        $p = $_POST['check_pass'];
        if (preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $p)) {
            echo " - Пароль надійний!";
        } else {
            echo " - Пароль слабкий!";
        }
    }
    ?>
</form>

</body>
</html>
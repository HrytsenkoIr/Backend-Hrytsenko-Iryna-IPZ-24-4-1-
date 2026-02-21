<?php
$login = preg_replace('/[^a-zA-Z0-9]/', '', $_POST['login']);
$baseDir = "users/" . $login;

if (is_dir($baseDir)) {
    echo "Помилка: Папка для користувача $login вже існує.";
} else {
    $subfolders = ['video', 'music', 'photo'];

    foreach ($subfolders as $folder) {
        mkdir($baseDir . '/' . $folder, 0777, true);
        file_put_contents($baseDir . '/' . $folder . '/readme.txt', "Це тестовий файл у папці $folder");
    }

    echo "Папки для $login успішно створені!";
}
?>
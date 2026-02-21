<?php
function removeDirectory($dir) {
    if (!is_dir($dir)) return;

    $files = array_diff(scandir($dir), ['.', '..']);
    foreach ($files as $file) {
        $path = $dir . DIRECTORY_SEPARATOR . $file;
        is_dir($path) ? removeDirectory($path) : unlink($path);
    }
    return rmdir($dir);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = preg_replace('/[^a-zA-Z0-9]/', '', $_POST['login']);
    $dirToDelete = "users/" . $login;

    if (is_dir($dirToDelete)) {
        if (removeDirectory($dirToDelete)) {
            echo "Папка користувача $login та весь її вміст успішно видалені.";
        } else {
            echo "Помилка при видаленні.";
        }
    } else {
        echo "Папка не знайдена.";
    }
}
?>

<form method="POST">
    <h3>Видалення користувача</h3>
    <input type="text" name="login" placeholder="Логін" required>
    <input type="password" name="password" placeholder="Пароль" required>
    <button type="submit">Видалити папку</button>
</form>
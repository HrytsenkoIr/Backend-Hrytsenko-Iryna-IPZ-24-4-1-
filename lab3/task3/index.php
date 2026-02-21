<?php
require_once 'classes.php';

$gb = new Guestbook();
$fm = new FileSetManager();
$ws = new WordSorter();

if (isset($_POST['add_comment'])) $gb->addComment($_POST['name'], $_POST['comment']);
if (isset($_POST['process_files'])) $fm->processFiles('file1.txt', 'file2.txt');
if (isset($_POST['delete_file'])) $message = $fm->deleteFile($_POST['filename']);
if (isset($_POST['sort_words'])) $ws->sortWords('words.txt');
?>

<!DOCTYPE html>
<html>
<body>

<h2>Гостьова книга</h2>
<form method="POST">
    <input type="text" name="name" placeholder="Ім'я" required><br>
    <textarea name="comment" placeholder="Коментар" required></textarea><br>
    <button type="submit" name="add_comment">Додати</button>
</form>

<table border="1">
    <?php foreach ($gb->getComments() as $row): ?>
        <tr><td><?= $row[0] ?></td><td><?= $row[1] ?? '' ?></td></tr>
    <?php endforeach; ?>
</table>

<hr>

<h2>Робота з файлами (Слова)</h2>
<form method="POST">
    <button type="submit" name="process_files">Обробити файли (створити нові)</button>
</form>

<form method="POST">
    <input type="text" name="filename" placeholder="Назва файлу для видалення">
    <button type="submit" name="delete_file">Видалити</button>
</form>
<p><?= $message ?? '' ?></p>

<hr>

<h2>Сортування слів</h2>
<form method="POST">
    <button type="submit" name="sort_words">Відсортувати слова з words.txt</button>
</form>

</body>
</html>
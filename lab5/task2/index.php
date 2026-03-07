<?php
require_once '../db.php';
?>
<!DOCTYPE html>
<html>
<head><title>База даних товарів</title></head>
<body>
<h2>Список товарів</h2>
<table border="1">
    <tr><th>ID</th><th>Назва</th><th>Ціна</th><th>Кількість</th><th>Дата</th></tr>
    <?php
    $result = $pdo->query("SELECT * FROM tov");
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr><td>{$row['id']}</td><td>{$row['name']}</td><td>{$row['cost']}</td><td>{$row['kol']}</td><td>{$row['date']}</td></tr>";
    }
    ?>
</table>

<hr>
<h3>Додати запис</h3>
<form action="insert.php" method="POST">
    Назва: <input type="text" name="name" required><br>
    Ціна: <input type="number" name="cost" required><br>
    Кількість: <input type="number" name="kol" required><br>
    Дата (РРРР-ММ-ДД): <input type="date" name="date" required><br>
    <button type="submit">Додати запис</button>
</form>

<hr>
<h3>Вилучити запис</h3>
<form action="delete.php" method="POST">
    Введіть ID для видалення: <input type="number" name="id" required>
    <button type="submit">Вилучити</button>
</form>
</body>
</html>
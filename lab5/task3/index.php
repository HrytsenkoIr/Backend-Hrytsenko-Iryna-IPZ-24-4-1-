<?php require '../db_company.php'; ?>
<h1>Працівники</h1>
<table border="1">
    <tr><th>ID</th><th>Ім'я</th><th>Посада</th><th>З/П</th><th>Дії</th></tr>
    <?php
    $res = $pdo->query("SELECT * FROM employees");
    foreach($res as $row) {
        echo "<tr><td>{$row['id']}</td><td>{$row['name']}</td><td>{$row['position']}</td><td>{$row['salary']}</td>
              <td><a href='edit.php?id={$row['id']}'>Ред.</a> <a href='delete.php?id={$row['id']}'>Вид.</a></td></tr>";
    }
    ?>
</table>
<a href="add.php">Додати працівника</a>
<a href="stats.php">Переглянути статистику</a>
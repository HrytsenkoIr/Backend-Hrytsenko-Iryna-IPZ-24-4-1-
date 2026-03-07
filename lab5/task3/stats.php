<?php
require '../db_company.php';

$total_employees = $pdo->query("SELECT COUNT(*) FROM employees")->fetchColumn();

$avg_salary = $pdo->query("SELECT AVG(salary) FROM employees")->fetchColumn();

$stats_by_position = $pdo->query("SELECT position, COUNT(*) as count FROM employees GROUP BY position");
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Статистика працівників</title>
</head>
<body>
<h1>Статистика компанії</h1>

<div style="margin-bottom: 20px;">
    <p>Загальна кількість працівників: <strong><?php echo $total_employees; ?></strong></p>
    <p>Середня заробітна плата: <strong><?php echo number_format($avg_salary, 2); ?></strong></p>
</div>

<h3>Працівники за посадами:</h3>
<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>Посада</th>
        <th>Кількість осіб</th>
    </tr>
    <?php foreach ($stats_by_position as $row): ?>
        <tr>
            <td><?php echo $row['position']; ?></td>
            <td><?php echo $row['count']; ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<br>
<a href="index.php">Повернутися до списку працівників</a>
</body>
</html>
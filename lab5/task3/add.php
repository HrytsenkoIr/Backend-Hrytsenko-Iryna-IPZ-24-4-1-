<?php require '../db_company.php';
if ($_POST) {
    $pdo->prepare("INSERT INTO employees (name, position, salary) VALUES (?, ?, ?)")
        ->execute([$_POST['name'], $_POST['position'], $_POST['salary']]);
    header("Location: index.php");
}
?>
<form method="POST">
    <input type="text" name="name" placeholder="Ім'я"><br>
    <input type="text" name="position" placeholder="Посада"><br>
    <input type="number" name="salary" placeholder="Зарплата"><br>
    <button type="submit">Додати</button>
</form>
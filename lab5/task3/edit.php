<?php require '../db_company.php';
$id = $_GET['id'];
if ($_POST) {
    $pdo->prepare("UPDATE employees SET name=?, position=?, salary=? WHERE id=?")
        ->execute([$_POST['name'], $_POST['position'], $_POST['salary'], $id]);
    header("Location: index.php");
}
$emp = $pdo->prepare("SELECT * FROM employees WHERE id=?");
$emp->execute([$id]);
$row = $emp->fetch();
?>
<form method="POST">
    <input type="text" name="name" value="<?php echo $row['name']; ?>">
    <input type="text" name="position" value="<?php echo $row['position']; ?>">
    <input type="number" name="salary" value="<?php echo $row['salary']; ?>">
    <button type="submit">Зберегти</button>
</form>
<?php
require_once '../db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sql = "INSERT INTO `tov` (`name`, `cost`, `kol`, `date`) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_POST['name'], $_POST['cost'], $_POST['kol'], $_POST['date']]);
    header("Location: index.php");
}
?>
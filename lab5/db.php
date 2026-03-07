<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=lab5;charset=utf8', 'homeuser', 'iryna_067');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo $e->getMessage();
}
?>
<?php

require_once __DIR__ . "/traffic_logger.php";
require_once "core/Database.php";

// Завдання 6, додаткова частина.
// Додаткові функції:
//Реалізувати перегляд статистики через stats.php, який рахує кількість 404 помилок за останню добу.
//Якщо відсоток 404 помилок перевищує 10% від загальної кількості запитів, надсилати адміністратору повідомлення.

$db = Database::getInstance();

$timeLimit = time() - 86400;
$adminEmail = "admin@example.com";

// Загальна кількість запитів за останню добу
$totalResult = $db->query("
    SELECT COUNT(*) as total
    FROM logs
    WHERE time > $timeLimit
");
$totalRow = $totalResult->fetchArray(SQLITE3_ASSOC);
$total = $totalRow['total'];

$errorResult = $db->query("
    SELECT COUNT(*) as errors
    FROM logs
    WHERE status = 404 AND time > $timeLimit
");
$errorRow = $errorResult->fetchArray(SQLITE3_ASSOC);
$errors = $errorRow['errors'];

// Відсоток 404 рахується від усіх запитів за 24 години
$percent = $total > 0 ? ($errors / $total) * 100 : 0;

echo "<h1>Statistics</h1>";
echo "Total requests (24h): " . $total . "<br>";
echo "404 errors (24h): " . $errors . "<br>";
echo "404 percent (24h): " . round($percent, 2) . "%<br>";

// Якщо 404 більше ніж 10%, пробуємо відправити лист адміністратору
if ($percent > 10) {
    $subject = "High 404 rate detected";
    $message = "404 errors in the last 24 hours: " . $errors . "\n"
        . "Total requests in the last 24 hours: " . $total . "\n"
        . "404 percentage: " . round($percent, 2) . "%";

    $mailSent = @mail($adminEmail, $subject, $message);

    if ($mailSent) {
        echo "<b>Warning: Too many 404 errors! Administrator notified.</b>";
    } else {
        echo "<b>Warning: Too many 404 errors! Administrator notification could not be sent.</b>";
    }
}

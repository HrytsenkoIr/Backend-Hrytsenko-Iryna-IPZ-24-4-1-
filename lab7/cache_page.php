<?php

require_once __DIR__ . "/traffic_logger.php";

// Створіть PHP-скрипт cache_page.php, який реалізує кешування сторінки залежно від статус-коду відповіді.
//
//Умови:
//1. Якщо сторінка віддає статус 200 OK, її вміст зберігається у файлі кешу cache.html.
//2. Якщо статус 404 Not Found, кешування не відбувається, а файл cache.html (якщо він існує) видаляється.
//3. Якщо користувач відвідує сторінку повторно, і є кеш-файл, вміст віддається з нього без повторної генерації сторінки.
//
//Підказка:
//Використовуйте ob_start() для збору вмісту сторінки.
//Використовуйте ob_get_contents() для отримання вмісту кешу.
//Використовуйте file_put_contents() для запису кешу.
//Використовуйте file_get_contents() для видачі кешу.

$cacheFile = __DIR__ . "/cache.html";
$show404 = isset($_GET['notfound']) && $_GET['notfound'] === '1';

// якщо це не 404-режим і кеш уже є, одразу віддає з файла і ст більше не генерується повторно
if (!$show404 && file_exists($cacheFile)) {
    http_response_code(200);
    TrafficLogger::log();
    header("Content-Type: text/html; charset=utf-8");
    echo file_get_contents($cacheFile);
    exit;
}

// буферзбирає HTML сторінки в пам'ять
ob_start();

//  поведінка при 404.
if ($show404) {
    http_response_code(404);

    echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <title>404 Not Found</title>
</head>
<body>
<h1>404 Not Found</h1>
<p>Cache page is unavailable.</p>
</body>
</html>";
} else {
    http_response_code(200);

    echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <title>Cache Page</title>
</head>
<body>
<h1>Cache Page</h1>
<p>This page is generated dynamically and stored in cache.</p>
</body>
</html>";
}

// Забирає з буфера готовий штмл і показує який статус зараз встановлений
$content = ob_get_contents();
$status = http_response_code();

// Якщо  успішно, записує HTML у cache.html
if ($status === 200) {
    file_put_contents($cacheFile, $content);
// Якщо сторінка 404, кеш не потрібен і тому видаляє старий файл
} elseif ($status === 404 && file_exists($cacheFile)) {
    unlink($cacheFile);
}

// віддає вміст буфера користувачу.
ob_end_flush();

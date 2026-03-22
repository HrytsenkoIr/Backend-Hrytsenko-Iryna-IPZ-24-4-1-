<?php

require_once __DIR__ . "/traffic_logger.php";
require_once __DIR__ . "/core/UrlHelper.php";

// Завдання 4. Гнучка система редиректів:
//
//Створіть скрипт redirect_manager.php, який дозволяє керувати перенаправленнями через конфігураційний файл.
//
//Умови:
//Є файл redirects.json зі списком перенаправлень:
//
//{
//	"/old-page": "/new-page",
//	"/deprecated": "/404"
//}
//
//Якщо користувач заходить на /old-page, його потрібно перенаправити на /new-page зі статусом 301 Moved Permanently.
//Якщо сторінка /deprecated, видавати 404 Not Found та відповідне повідомлення.
//Використовувати ob_start(), щоб контролювати вивід.
//
//Підказка:
//json_decode(file_get_contents("redirects.json"), true); дозволить отримати дані.
//header("Location: $new_url", true, 301); виконує перенаправлення.
//
ob_start();

// currentPath() бере шлях із REQUEST_URI і прибирає службову частину /lab7
$path = currentPath();

// Читає правила перенаправлень із JSON-файла
$rules = json_decode(file_get_contents(__DIR__ . "/redirects.json"), true);

if (isset($rules[$path])) {
    $target = $rules[$path];

    // Якщо в конфігурації ціль /404, не робить редирект, а повертає 404-сторінку
    if ($target === "/404") {
        if (ob_get_length()) {
            ob_clean();
        }

        http_response_code(404);
        echo "<h1>404 Not Found</h1>";
        echo "<p>This page is deprecated and no longer available.</p>";
        TrafficLogger::log();
        exit;
    }

    // Якщо для шляху є звичайна нова адреса, віддає 301 Moved Permanently
    if (ob_get_length()) {
        ob_clean();
    }

    http_response_code(301);
    header("Location: " . $target, true, 301);
    TrafficLogger::log();
    exit;
}

// Якщо правило не знайдено, прибирає порожній буфер і повертає керування далі
if (ob_get_length()) {
    ob_end_clean();
}

// Якщо файл відкрили напряму і правило не знайдено, показує звичайну відповідь 200
if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === __FILE__) {
    http_response_code(200);
    header("Content-Type: text/html; charset=utf-8");
    echo "<h1>200 OK</h1>";
    echo "<p>No redirect rule matched for this path.</p>";
    exit;
}

return;

<?php

require_once __DIR__ . "/traffic_logger.php";

// Завдання 2. Система захисту від перевантаження сервера (Rate Limiting):
//
//Створіть скрипт rate_limit.php, який обмежує кількість запитів від одного користувача та повертає відповідні статус-коди.
//
//Умови:
//Логувати IP-адресу користувача в файл requests.log.
//Якщо користувач зробив більше 5 запитів за хвилину, встановлювати статус 429 Too Many Requests і рекомендувати спробувати пізніше.
//Якщо ліміт не перевищено, видавати 200 OK та звичайний контент.
//
//Підказка:
//Використовуйте ob_start() для збору відповідей.
//Записуйте в лог: IP, час запиту.
//Видаляйте застарілі записи, щоб не накопичувати зайві дані.

function tooManyRequests($limit = 5, $windowSeconds = 60, $logFile = null)
{
    // IP користувача та час поточного запиту
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $now = time();
    $file = $logFile ?? __DIR__ . "/requests.log";

    // Читає старий лог і залишає тільки свіжі записи за останні 60 сек
    $lines = file_exists($file) ? file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];
    $freshLines = [];

    foreach ($lines as $line) {
        $parts = explode("|", trim($line));

        if (count($parts) !== 2) {
            continue;
        }

        $requestTime = (int)$parts[1];

        if (($now - $requestTime) < $windowSeconds) {
            $freshLines[] = $parts[0] . "|" . $requestTime;
        }
    }

    // Додає в лог поточний запит цього користувача
    $freshLines[] = $ip . "|" . $now;
    file_put_contents($file, implode(PHP_EOL, $freshLines) . PHP_EOL);

    // Рахуємо скільки свіжих запитів належить саме цьому IP
    $count = 0;

    foreach ($freshLines as $line) {
        $parts = explode("|", $line);

        if (($parts[0] ?? '') === $ip) {
            $count++;
        }
    }

    return $count > $limit;
}

function handleRatePage($limit = 5, $windowSeconds = 60, $logFile = null)
{
    // Буфер щоб можна було очистити випадковий вивід перед відповіддю
    if (ob_get_level() === 0) {
        ob_start();
    }

    $blocked = tooManyRequests($limit, $windowSeconds, $logFile);

    // Якщо щось уже потрапило в буфер прибирає це перед відправкою статусу і штмл
    if (ob_get_length()) {
        ob_clean();
    }

    header("Content-Type: text/html; charset=utf-8");

    // Якщо ліміт перевищено, повертає 429 і просить спробувати пізніше
    if ($blocked) {
        http_response_code(429);
        echo "<h1>429 Too Many Requests</h1>";
        echo "<p>Too many requests from your IP address. Please try again later.</p>";
        return true;
    }

    // Якщо ліміт не перевищено, сторінка працює як звичайно зі статусом 200
    http_response_code(200);
    echo "<h1>200 OK</h1>";
    echo "<p>Request accepted. Normal content is displayed.</p>";

    return false;
}

// Якщо файл відкрили напряму, запускає перевірку прямо тут
if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === __FILE__) {
    handleRatePage();
}

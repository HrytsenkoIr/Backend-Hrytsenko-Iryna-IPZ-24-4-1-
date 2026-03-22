<?php

require_once __DIR__ . "/core/TrafficLogger.php";

// Завдання 6. Аналіз трафіку та відповідей сервера:
//
//Розробіть traffic_logger.php, який записує інформацію про всі запити в базу даних.
//
//Що зберігати в БД?
//IP-адресу
//Час запиту
//Запитаний URL
//Відповідний HTTP-статус
//
//Додаткові функції:
//Реалізувати перегляд статистики через stats.php, який рахує кількість 404 помилок за останню добу.
//Якщо відсоток 404 помилок перевищує 10% від загальної кількості запитів, надсилати адміністратору повідомлення.
//
//Підказка:
//Використовуйте MySQL (або SQLite) для збереження даних.
//Функція http_response_code() допоможе отримати поточний статус.

if (!function_exists('logTrafficRequest')) {
    function logTrafficRequest()
    {
        // У кінці запиту запускаємо запис у БД так тип краще бо до цього моменту статус відповіді вже зазвичай відомий
        TrafficLogger::log();
    }
}

if (!defined('TRAFFIC_LOGGER_REGISTERED')) {
    define('TRAFFIC_LOGGER_REGISTERED', true);

    // shutdown-функція спрацює навіть наприкінці звичайного запиту
    register_shutdown_function('logTrafficRequest');
}

// Якщо файл відкрили прямо в браузері, показує просту службову сторінку
if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === __FILE__) {
    if (ob_get_level() === 0) {
        ob_start();
    }

    if (http_response_code() === false || http_response_code() === 0) {
        http_response_code(200);
    }

    if (ob_get_length()) {
        ob_clean();
    }

    header("Content-Type: text/html; charset=utf-8");
    echo "<h1>Traffic Logged</h1>";
    echo "<p>All request information will be written to the database automatically.</p>";
}

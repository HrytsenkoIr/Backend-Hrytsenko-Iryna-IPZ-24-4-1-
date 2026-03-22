<?php

require_once __DIR__ . "/traffic_logger.php";

// Перехоплення помилок та перенаправлення:
//Створіть скрипт error_handler.php, який перехоплює фатальні помилки та замість стандартного повідомлення показує кастомну сторінку з відповідним статус-кодом.
//
//Умови:
//Використовуйте register_shutdown_function(), щоб обробляти E_ERROR.
//Якщо сталася помилка:
//Очистити буфер ob_clean()
//Встановити статус 500 Internal Server Error
//Показати сторінку з вибаченням та часом, коли проблема буде вирішена.
//Якщо помилок немає, віддавати 200 OK.
//
//Підказка:
//error_get_last() допоможе отримати останню помилку.
//Використовуйте ob_start(), щоб уникнути передчасного виводу.

function startErrorHandler()
{
    // Запускає буфер, щоб у разі помилки можна було очистити попередній вивід
    if (ob_get_level() === 0) {
        ob_start();
    }

    // shutdown-функція викликається в кінці роботи скрипта
    // Тут можна перевірити, чи не завершився скрипт через фатальну помилку
    register_shutdown_function(function () {
        $error = error_get_last();

        if ($error && $error['type'] === E_ERROR) {
            // Якщо помилка фатальна, очищає те, що могло встигнути вивестись раніше
            if (ob_get_length()) {
                ob_clean();
            }

            http_response_code(500);
            header("Content-Type: text/html; charset=utf-8");

            // приблизний час виправлення бо нада
            $resolvedAt = date('Y-m-d H:i', time() + 3600);

            echo "<h1>500 Internal Server Error</h1>";
            echo "<p>Sorry, something went wrong on the server.</p>";
            echo "<p>We expect to resolve the problem by {$resolvedAt}.</p>";

            // Після помилки також записує цей запит у лог
            TrafficLogger::log();
            exit;
        }

        // Якщо фатальної помилки не було і статус ще не встановлений, ставить звичайний 200
        if (http_response_code() === false || http_response_code() === 0) {
            http_response_code(200);
        }
    });
}

// Вмикає обробник одразу після підключення файла
startErrorHandler();

// Цей блок потрібен для окремого тесту файла без головного index.php.
if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === __FILE__) {
    if (isset($_GET['trigger']) && $_GET['trigger'] === '1') {
        undefined_function_for_test();
    }

    http_response_code(200);
    header("Content-Type: text/html; charset=utf-8");

    if (ob_get_length()) {
        ob_clean();
    }

    echo "<h1>200 OK</h1>";
    echo "<p>No fatal errors were detected.</p>";
}

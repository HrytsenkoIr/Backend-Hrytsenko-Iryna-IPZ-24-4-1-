<?php

// Завдання 5. Динамічне підключення заголовків без видимого виводу:
//
//Створіть PHP-клас Response, який допомагає керувати HTTP-заголовками та буферизацією.
//
//Функціонал класу:
//Метод setStatus($code), який встановлює HTTP-статус.
//Метод addHeader($header), який додає заголовок (наприклад, Content-Type).
//Метод send($content), який очищає буфер, додає заголовки та відправляє відповідь.
//
//Приклад використання:
//
//$response = new Response();
//$response->setStatus(200);
//$response->addHeader("Content-Type: text/html");
//$response->send("<h1>Вітаємо!</h1><p>Це динамічна відповідь.</p>");
//
//Підказка:
//Використовуйте header() всередині методу setStatus().
//Використовуйте ob_start(), ob_clean() перед виводом контенту.

class Response
{
    private $status = 200;
    private $headers = array();

    // Цей метод збирає повний рядок статусу, наприклад HTTP/1.1 404 Not Found
    private function getStatusLine($code)
    {
        $messages = array(
            200 => 'OK',
            301 => 'Moved Permanently',
            404 => 'Not Found',
            429 => 'Too Many Requests',
            500 => 'Internal Server Error',
        );

        $message = isset($messages[$code]) ? $messages[$code] : 'OK';
        $protocol = isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.1';

        return $protocol . ' ' . $code . ' ' . $message;
    }

    public function setStatus($code)
    {
        // Зберігає код у властивість і одразу готує HTTP-статус через header()
        $this->status = $code;
        header($this->getStatusLine($code), true, $code);
    }

    public function addHeader($header)
    {
        // Складає заголовки в масив, щоб відправити їх пізніше разом
        $this->headers[] = $header;
    }

    public function send($content)
    {
        // Якщо буфер ще не запущений, запускає його
        if (ob_get_level() === 0) {
            ob_start();
        }

        // Прибирає все, що могло випадково вивестись раніше
        if (ob_get_length()) {
            ob_clean();
        }

        // Відправляє фінальний статус і всі заголовки
        header($this->getStatusLine($this->status), true, $this->status);

        foreach ($this->headers as $header) {
            header($header);
        }

        // Виводить контент і завершує виконання
        echo $content;
        exit;
    }
}

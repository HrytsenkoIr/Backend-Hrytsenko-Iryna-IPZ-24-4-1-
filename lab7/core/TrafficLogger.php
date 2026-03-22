<?php

require_once "Database.php";
require_once "Request.php";

// Цей клас відповідає саме за запис у таблицю logs.
// Його викликає traffic_logger.php наприкінці запиту.
// Дані про IP, URL і час приходять із об'єкта Request.

class TrafficLogger
{
    private static $logged = false;

    public static function log()
    {
        // Захист від дубля: один і той самий запит не повинен записуватись у БД двічі.
        if (self::$logged) {
            return;
        }

        $db = Database::getInstance();
        $request = new Request();
        $status = http_response_code();

        // Якщо статус ще не встановлений явно, вважаємо відповідь звичайною 200.
        if ($status === false || $status === 0) {
            $status = 200;
        }

        // Підготовлений запит безпечніше вставляє дані в БД.
        $stmt = $db->prepare("
            INSERT INTO logs (ip, url, time, status)
            VALUES (:ip, :url, :time, :status)
        ");

        $stmt->bindValue(':ip', $request->ip);
        $stmt->bindValue(':url', $request->url);
        $stmt->bindValue(':time', $request->time);
        $stmt->bindValue(':status', $status);

        $stmt->execute();
        self::$logged = true;
    }
}

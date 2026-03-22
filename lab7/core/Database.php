<?php

class Database
{
    private static $instance = null;

    public static function getInstance()
    {
        // підключення один раз за запит
        if (self::$instance === null) {
            self::$instance = new SQLite3(__DIR__ . "/traffic.db");

            self::$instance->exec("
                CREATE TABLE IF NOT EXISTS logs (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    ip TEXT,
                    url TEXT,
                    time INTEGER,
                    status INTEGER
                )
            ");
        }

        return self::$instance;
    }
}

<?php

// Допоміжна функція для маршрутизації.
// Вона бере шлях із REQUEST_URI і прибирає префікс /lab7,
// щоб в index.php і redirect_manager.php було простіше порівнювати маршрути.

function currentPath()
{
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = str_replace("/lab7", "", $uri);

    return $uri === "" ? "/" : $uri;
}

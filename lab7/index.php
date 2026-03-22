<?php

require_once __DIR__ . "/traffic_logger.php";
require_once __DIR__ . "/core/UrlHelper.php";
require_once __DIR__ . "/error_handler.php";
require_once __DIR__ . "/rate_limit.php";
require_once __DIR__ . "/redirect_manager.php";

$path = currentPath();

if ($path === "/rate") {
    handleRatePage();
    exit;
} elseif ($path === "/cache") {
    require __DIR__ . "/cache_page.php";
} elseif ($path === "/stats") {
    http_response_code(200);
    require __DIR__ . "/stats.php";
} elseif ($path === "/") {
    http_response_code(200);
    echo "<h1>Home page</h1>";
} elseif ($path === "/test") {
    http_response_code(200);
    undefined_function_for_test();
} else {
    http_response_code(404);
    echo "<h1>404 Not Found</h1>";
    echo "<p>$path</p>";
}

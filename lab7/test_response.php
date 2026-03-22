<?php

require_once "core/Response.php";

$response = new Response();
$response->setStatus(200);
$response->addHeader("Content-Type: text/html");
$response->send("<h1>Test OK</h1>");
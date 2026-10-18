<?php

$basePath = dirname(__DIR__);
require $basePath . "/vendor/autoload.php";
require_once $basePath . "/src/View/helpers.php";
$app = new Beaver\Foundation\Application($basePath);
$app->boot();
require $basePath . "/routes/web.php";
$app->handleHttp();

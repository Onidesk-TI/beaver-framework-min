<?php
$t = "/tmp/boot-debug.log";
@unlink($t);
function logx($m) { global $t; file_put_contents($t, date("H:i:s") . " $m\n", FILE_APPEND); }
logx("1 start");
$basePath = dirname(__DIR__);
logx("2 basePath=" . $basePath);
require $basePath . "/vendor/autoload.php";
logx("3 autoload ok");
require_once $basePath . "/src/View/helpers.php";
logx("4 helpers ok");
$app = new Beaver\Foundation\Application($basePath);
logx("5 Application ctor ok");
$app->boot();
logx("6 boot ok");
require $basePath . "/routes/web.php";
logx("7 routes ok");
$app->handleHttp();
logx("8 handleHttp ok");

<?php
declare(strict_types=1);

use Beaver\Http\Response;
use Beaver\Http\Router;

$router = Router::current();

// ─── Home ───
$router->get('/', function () {
    $view = dirname(__DIR__) . '/app/views/home.php';
    if (!is_file($view)) {
        return Response::text('View home.php nao encontrada', 500);
    }
    ob_start();
    require $view;
    return Response::html(ob_get_clean());
});

// ─── Healthcheck ───
$router->get('/ping', fn() => Response::json([
    'ok'      => true,
    'min'     => true,
    'version' => '0.1.0',
    'time'    => date('c'),
]));

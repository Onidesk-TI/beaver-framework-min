<?php
declare(strict_types=1);

use Beaver\Http\Response;

/** @var \Beaver\Http\Router $router */

$router->get('/human-check', function () {
    if (session_status() === PHP_SESSION_NONE) session_start();

    $a = random_int(2, 9);
    $b = random_int(2, 9);
    $_SESSION['hc_a'] = $a;
    $_SESSION['hc_b'] = $b;

    // Render view e devolver Response::html() — força Content-Type: text/html
    ob_start();
    require dirname(__DIR__) . '/resources/views/widget.php';
    $html = ob_get_clean();

    return Response::html($html);
});

$router->post('/human-check', function () {
    if (session_status() === PHP_SESSION_NONE) session_start();

    $expected = (int)($_SESSION['hc_a'] ?? 0) + (int)($_SESSION['hc_b'] ?? 0);
    $given    = (int)($_POST['answer'] ?? -1);
    unset($_SESSION['hc_a'], $_SESSION['hc_b']);

    $_SESSION[$given === $expected ? 'flash_ok' : 'flash_erro']
        = $given === $expected ? '✓ Verificação passou!' : 'Resposta errada.';

    header('Location: /human-check');
    exit;
});

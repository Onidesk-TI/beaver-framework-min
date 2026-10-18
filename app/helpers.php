<?php
declare(strict_types=1);

if (!function_exists('url')) {
    function url(string $path = ''): string
    {
        $base = rtrim((string) config('app.url', ''), '/');
        if ($base === '') {
            $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
            $host   = $_SERVER['HTTP_HOST'] ?? 'localhost';
            $base   = $scheme . '://' . $host;
        }
        if ($path === '') return $base;
        return $base . '/' . ltrim($path, '/');
    }
}

if (!function_exists('url_path')) {
    function url_path(string $path = '/'): string
    {
        $base   = (string) config('app.url', '');
        $prefix = '';
        if ($base !== '') {
            $p = parse_url($base, PHP_URL_PATH);
            if (is_string($p)) $prefix = rtrim($p, '/');
        }
        return $prefix . '/' . ltrim($path, '/');
    }
}

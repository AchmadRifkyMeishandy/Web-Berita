<?php

declare(strict_types=1);

namespace App\Core;

final class Csrf
{
    public static function token(): string
    {
        if (empty($_SESSION['_csrf_token'])) {
            $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
        }
        return (string) $_SESSION['_csrf_token'];
    }

    public static function verify(mixed $token): bool
    {
        return is_string($token)
            && isset($_SESSION['_csrf_token'])
            && hash_equals((string) $_SESSION['_csrf_token'], $token);
    }

    public static function requireValidRequest(): void
    {
        if (!self::verify($_POST['_token'] ?? null)) {
            http_response_code(419);
            echo '<!doctype html><html lang="id"><meta charset="utf-8"><title>Sesi formulir berakhir</title><h1>Sesi formulir berakhir</h1><p>Muat ulang halaman lalu coba lagi.</p></html>';
            exit;
        }
    }
}

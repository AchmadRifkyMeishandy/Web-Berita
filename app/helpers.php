<?php

declare(strict_types=1);

use App\Core\Csrf;

function e(mixed $value): string
{
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function url(string $route = 'home', array $parameters = []): string
{
    $scriptPath = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '/index.php');
    $basePath = rtrim(dirname($scriptPath), '/.');
    $query = array_merge(['route' => $route], $parameters);
    return ($basePath === '' ? '' : $basePath) . '/index.php?' . http_build_query($query);
}

function asset(string $path): string
{
    $scriptPath = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '/index.php');
    $basePath = rtrim(dirname($scriptPath), '/.');
    return ($basePath === '' ? '' : $basePath) . '/assets/' . ltrim($path, '/');
}

function image_url(?string $imagePath): string
{
    $imagePath = trim((string) $imagePath);
    if ($imagePath === '') {
        return asset('images/news-placeholder.svg');
    }
    $imagePath = str_replace('\\', '/', $imagePath);
    if (str_contains($imagePath, '..') || str_starts_with($imagePath, '/') || preg_match('/^[a-z]+:/i', $imagePath)) {
        return asset('images/news-placeholder.svg');
    }
    $relativePath = 'images/' . ltrim($imagePath, '/');
    $absolutePath = dirname(__DIR__) . '/public/assets/' . $relativePath;
    if (!is_file($absolutePath)) {
        return asset('images/news-placeholder.svg');
    }
    return asset($relativePath);
}

function csrf_token(): string
{
    return Csrf::token();
}

function csrf_input(): string
{
    return '<input type="hidden" name="_token" value="' . e(csrf_token()) . '">';
}

function flash(string $key, ?string $message = null): ?string
{
    if ($message !== null) {
        $_SESSION['_flash'][$key] = $message;
        return null;
    }
    $value = $_SESSION['_flash'][$key] ?? null;
    unset($_SESSION['_flash'][$key]);
    return is_string($value) ? $value : null;
}

function format_date(?string $date): string
{
    if (!$date) {
        return 'Tanggal tidak tersedia';
    }
    try {
        return (new DateTimeImmutable($date))->format('d F Y');
    } catch (Throwable) {
        return $date;
    }
}

function current_admin_name(): string
{
    return (string) ($_SESSION['admin_name'] ?? 'Administrator');
}


function slugify(string $value): string
{
    $value = trim(function_exists('mb_strtolower') ? mb_strtolower($value, 'UTF-8') : strtolower($value));
    $value = preg_replace('/[^\pL\pN]+/u', '-', $value) ?? '';
    return trim($value, '-');
}


function text_length(string $value): int
{
    return function_exists('mb_strlen') ? mb_strlen($value, 'UTF-8') : strlen($value);
}

function text_excerpt(string $value, int $maxLength = 150): string
{
    $value = trim(preg_replace('/\s+/u', ' ', strip_tags($value)) ?? $value);
    if (function_exists('mb_strimwidth')) {
        return mb_strimwidth($value, 0, $maxLength, '…', 'UTF-8');
    }
    return strlen($value) > $maxLength ? substr($value, 0, max(0, $maxLength - 3)) . '...' : $value;
}

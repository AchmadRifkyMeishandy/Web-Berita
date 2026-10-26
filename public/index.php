<?php

declare(strict_types=1);

use App\Core\Router;

require dirname(__DIR__) . '/bootstrap.php';

try {
    $router = new Router(require dirname(__DIR__) . '/routes/web.php');
    $router->dispatch();

} catch (Throwable $exception) {
    error_log('Application error: ' . $exception->getMessage() . "\n" . $exception->getTraceAsString());
    http_response_code(500);
    require dirname(__DIR__) . '/app/Views/errors/500.php';
}

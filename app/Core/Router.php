<?php

declare(strict_types=1);

namespace App\Core;

final class Router
{
    public function __construct(private array $routes)
    {
    }

    public function dispatch(): void
    {
        $routeName = is_string($_GET['route'] ?? null) ? $_GET['route'] : 'home';

        $method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');

        $route = $this->routes[$routeName] ?? null;

        if ($route === null) {
            http_response_code(404);
            View::render('errors/404', [], 'public');
            return;
        }
        if (!isset($route[$method])) {
            http_response_code(405);
            header('Allow: ' . implode(', ', array_keys($route)));
            View::render('errors/405', [], 'public');
            return;
        }

        [$controllerClass, $action] = $route[$method];
        $controller = new $controllerClass();
        $controller->{$action}();
    }
}

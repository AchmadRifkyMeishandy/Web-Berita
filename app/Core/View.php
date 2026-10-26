<?php

declare(strict_types=1);

namespace App\Core;

use RuntimeException;

final class View
{
    public static function render(string $view, array $data = [], string $layout = 'public'): void
    {
        $viewPath = dirname(__DIR__) . '/Views/' . $view . '.php';
        if (!is_file($viewPath)) {
            throw new RuntimeException('View not found: ' . $view);
        }

        extract($data, EXTR_SKIP);
        ob_start();
        require $viewPath;
        $content = (string) ob_get_clean();

        if ($layout === 'none') {
            echo $content;
            return;
        }

        $layoutPath = dirname(__DIR__) . '/Views/layouts/' . $layout . '.php';
        if (!is_file($layoutPath)) {
            throw new RuntimeException('Layout not found: ' . $layout);
        }
        require $layoutPath;
    }
}

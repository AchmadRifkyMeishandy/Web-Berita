<?php

declare(strict_types=1);

namespace App\Core;

use App\Models\Category;

abstract class Controller
{
    protected function render(string $view, array $data = [], string $layout = 'public'): void
    {
        if ($layout === 'public' && !array_key_exists('navigationCategories', $data)) {
            $data['navigationCategories'] = Category::all();
        }
        $data['currentRoute'] = (string) ($_GET['route'] ?? 'home');
        View::render($view, $data, $layout);
    }

    protected function redirect(string $route, array $parameters = []): never
    {
        header('Location: ' . url($route, $parameters));
        exit;
    }

    protected function requireAdmin(): void
    {
        if (empty($_SESSION['admin_id']) || ($_SESSION['admin_role'] ?? '') !== 'admin') {
            flash('error', 'Silakan masuk sebagai admin terlebih dahulu.');
            $this->redirect('admin.login');
        }
    }

    protected function validId(mixed $rawId): ?int
    {
        $id = filter_var($rawId, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        return $id === false ? null : ($id === null ? null : (int) $id);
    }
}

<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Database;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

final class DashboardController extends Controller
{
    public function index(): void
    {
        $this->requireAdmin();
        $pdo = Database::connection();
        $commentCount = (int) $pdo->query('SELECT COUNT(*) FROM comments')->fetchColumn();
        $this->render('admin/dashboard', [
            'pageTitle' => 'Dashboard',
            'articleCount' => Article::countAll(),
            'categoryCount' => Category::countAll(),
            'commentCount' => $commentCount,
            'userCount' => User::countAll(),
            'successMessage' => flash('success'),
            'errorMessage' => flash('error'),
        ], 'admin');
    }
}

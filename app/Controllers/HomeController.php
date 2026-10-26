<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Article;

final class HomeController extends Controller
{
    public function index(): void
    {
        $this->render('public/home', [
            'pageTitle' => 'Berita Indonesia — Kabar dan Perspektif',
            'articleCount' => Article::countAll(),
            'articles' => Article::latest(6),
        ]);
    }
}

<?php

use App\Controllers\Admin\ArticleController as AdminArticleController;
use App\Controllers\Admin\AuthController;
use App\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Controllers\Admin\CommentController as AdminCommentController;
use App\Controllers\Admin\DashboardController;
use App\Controllers\ArticleController;
use App\Controllers\HomeController;

return [
    'home' => ['GET' => [HomeController::class, 'index']],
    'articles.index' => ['GET' => [ArticleController::class, 'index']],
    'articles.show' => ['GET' => [ArticleController::class, 'show']],
    'comments.store' => ['POST' => [ArticleController::class, 'storeComment']],
    'replies.store' => ['POST' => [ArticleController::class, 'storeReply']],

    'admin.login' => [
        'GET' => [AuthController::class, 'login'],
        'POST' => [AuthController::class, 'authenticate'],
    ],
    'admin.logout' => ['POST' => [AuthController::class, 'logout']],
    'admin.dashboard' => ['GET' => [DashboardController::class, 'index']],

    'admin.articles.index' => ['GET' => [AdminArticleController::class, 'index']],
    'admin.articles.create' => ['GET' => [AdminArticleController::class, 'create']],
    'admin.articles.store' => ['POST' => [AdminArticleController::class, 'store']],
    'admin.articles.edit' => ['GET' => [AdminArticleController::class, 'edit']],
    'admin.articles.update' => ['POST' => [AdminArticleController::class, 'update']],
    'admin.articles.delete' => ['POST' => [AdminArticleController::class, 'delete']],

    'admin.categories.index' => ['GET' => [AdminCategoryController::class, 'index']],
    'admin.categories.create' => ['GET' => [AdminCategoryController::class, 'create']],
    'admin.categories.store' => ['POST' => [AdminCategoryController::class, 'store']],
    'admin.categories.edit' => ['GET' => [AdminCategoryController::class, 'edit']],
    'admin.categories.update' => ['POST' => [AdminCategoryController::class, 'update']],
    'admin.categories.delete' => ['POST' => [AdminCategoryController::class, 'delete']],

    'admin.comments.index' => ['GET' => [AdminCommentController::class, 'index']],
    'admin.comments.delete' => ['POST' => [AdminCommentController::class, 'delete']],
];

<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Csrf;
use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;

final class ArticleController extends Controller
{
    public function index(): void
    {
        $categoryId = null;
        $category = null;
        $error = null;
        if (isset($_GET['category_id'])) {
            $categoryId = $this->validId($_GET['category_id']);
            if ($categoryId === null) {
                http_response_code(400);
                $error = 'Kategori yang diminta tidak valid.';
            } else {
                $category = Category::find($categoryId);
                if ($category === null) {
                    http_response_code(404);
                    $error = 'Kategori tidak ditemukan.';
                }
            }
        }

        $pageInput = filter_var($_GET['page'] ?? 1, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        $page = $pageInput === false ? 1 : (int) $pageInput;
        $pagination = ($error === null) ? Article::paginate($categoryId, $page, 9) : [
            'articles' => [], 'total' => 0, 'page' => 1, 'perPage' => 9, 'totalPages' => 1,
        ];

        $this->render('public/articles/index', [
            'pageTitle' => $category ? 'Berita: ' . $category['name'] : 'Semua berita',
            'category' => $category,
            'errorMessage' => $error,
            'pagination' => $pagination,
            'selectedCategoryId' => $categoryId,
        ]);
    }

    public function show(): void
    {
        $articleId = $this->validId($_GET['id'] ?? null);
        $article = $articleId ? Article::find($articleId) : null;
        if (!$article) {
            http_response_code(404);
        }

        $comments = $article ? Comment::forArticle((int) $article['id']) : [];
        $repliesByComment = [];
        if ($article) {
            foreach (Comment::repliesForArticle((int) $article['id']) as $reply) {
                $repliesByComment[(int) $reply['comment_id']][] = $reply;
            }
        }

        $this->render('public/articles/show', [
            'pageTitle' => $article ? $article['title'] . ' — Berita Indonesia' : 'Berita tidak ditemukan',
            'article' => $article,
            'comments' => $comments,
            'repliesByComment' => $repliesByComment,
            'errorMessage' => flash('error'),
            'successMessage' => flash('success'),
        ]);
    }

    public function storeComment(): void
    {
        Csrf::requireValidRequest();
        $articleId = $this->validId($_POST['article_id'] ?? null);
        $article = $articleId ? Article::find($articleId) : null;
        if (!$article) {
            http_response_code(404);
            $this->redirect('articles.index');
        }

        $name = trim(is_string($_POST['name'] ?? null) ? $_POST['name'] : '');
        $body = trim(is_string($_POST['body'] ?? null) ? $_POST['body'] : '');
        if ($name === '' || $body === '' || text_length($name) > 120 || text_length($body) > 10000) {
            flash('error', 'Nama wajib diisi (maksimal 120 karakter) dan komentar maksimal 10.000 karakter.');
        } else {
            Comment::create($articleId, $name, $body);
            flash('success', 'Komentar berhasil dikirim.');
        }
        $this->redirect('articles.show', ['id' => $articleId, 'section' => 'comments']);
    }

    public function storeReply(): void
    {
        Csrf::requireValidRequest();
        $articleId = $this->validId($_POST['article_id'] ?? null);
        $commentId = $this->validId($_POST['comment_id'] ?? null);
        $article = $articleId ? Article::find($articleId) : null;
        $parentComment = ($articleId && $commentId) ? Comment::findForArticle($commentId, $articleId) : null;
        if (!$article || !$parentComment) {
            flash('error', 'Komentar yang ingin dibalas tidak ditemukan.');
            $this->redirect('articles.show', $articleId ? ['id' => $articleId] : []);
        }

        $name = trim(is_string($_POST['name'] ?? null) ? $_POST['name'] : '');
        $body = trim(is_string($_POST['body'] ?? null) ? $_POST['body'] : '');
        if ($name === '' || $body === '' || text_length($name) > 120 || text_length($body) > 10000) {
            flash('error', 'Nama wajib diisi dan balasan maksimal 10.000 karakter.');
        } else {
            Comment::createReply($commentId, $name, $body);
            flash('success', 'Balasan berhasil dikirim.');
        }
        $this->redirect('articles.show', ['id' => $articleId, 'section' => 'comments']);
    }
}

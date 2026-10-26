<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Csrf;
use App\Models\Article;
use App\Models\Category;
use App\Services\ImageUploadService;
use Throwable;

final class ArticleController extends Controller
{
    public function index(): void
    {
        $this->requireAdmin();
        $this->render('admin/articles/index', [
            'pageTitle' => 'Kelola Berita',
            'articles' => Article::allForAdmin(),
            'successMessage' => flash('success'),
            'errorMessage' => flash('error'),
        ], 'admin');
    }

    public function create(): void
    {
        $this->requireAdmin();
        $this->render('admin/articles/form', [
            'pageTitle' => 'Tambah Berita', 'formAction' => url('admin.articles.store'),
            'article' => null, 'categories' => Category::all(),
            'successMessage' => null, 'errorMessage' => flash('error'),
        ], 'admin');
    }

    public function store(): void
    {
        $this->requireAdmin();
        Csrf::requireValidRequest();
        [$data, $error] = $this->validateArticleInput($_POST);
        if ($error !== null) {
            flash('error', $error);
            $this->redirect('admin.articles.create');
        }

        $uploadService = new ImageUploadService();
        $uploadedPath = null;
        try {
            if (isset($_FILES['image']) && ($_FILES['image']['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE) {
                $uploadedPath = $uploadService->store($_FILES['image']);
            } else {
                throw new \RuntimeException('Gambar berita wajib diunggah.');
            }
            $data['image_path'] = $uploadedPath;
            Article::create($data);
            flash('success', 'Berita berhasil ditambahkan.');
            $this->redirect('admin.articles.index');
        } catch (Throwable $exception) {
            if ($uploadedPath !== null) {
                $uploadService->deleteIfUploaded($uploadedPath);
            }
            error_log('Create article failed: ' . $exception->getMessage());
            flash('error', $exception instanceof \RuntimeException ? $exception->getMessage() : 'Berita gagal disimpan. Periksa data dan konfigurasi database.');
            $this->redirect('admin.articles.create');
        }
    }

    public function edit(): void
    {
        $this->requireAdmin();
        $articleId = $this->validId($_GET['id'] ?? null);
        $article = $articleId ? Article::find($articleId) : null;
        if (!$article) {
            flash('error', 'Berita tidak ditemukan.');
            $this->redirect('admin.articles.index');
        }
        $article['published_input'] = $article['published_at'] ? date('Y-m-d\TH:i', strtotime($article['published_at'])) : '';
        $this->render('admin/articles/form', [
            'pageTitle' => 'Edit Berita', 'formAction' => url('admin.articles.update', ['id' => $articleId]),
            'article' => $article, 'categories' => Category::all(),
            'successMessage' => null, 'errorMessage' => flash('error'),
        ], 'admin');
    }

    public function update(): void
    {
        $this->requireAdmin();
        Csrf::requireValidRequest();
        $articleId = $this->validId($_GET['id'] ?? $_POST['id'] ?? null);
        $existingArticle = $articleId ? Article::find($articleId) : null;
        if (!$existingArticle) {
            flash('error', 'Berita tidak ditemukan.');
            $this->redirect('admin.articles.index');
        }
        [$data, $error] = $this->validateArticleInput($_POST);
        if ($error !== null) {
            flash('error', $error);
            $this->redirect('admin.articles.edit', ['id' => $articleId]);
        }

        $uploadService = new ImageUploadService();
        $newImagePath = null;
        try {
            if (isset($_FILES['image']) && ($_FILES['image']['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE) {
                $newImagePath = $uploadService->store($_FILES['image']);
            }
            $data['image_path'] = $newImagePath ?? (string) $existingArticle['image_path'];
            Article::update($articleId, $data);
            if ($newImagePath !== null && $existingArticle['image_path'] !== $newImagePath) {
                $uploadService->deleteIfUploaded((string) $existingArticle['image_path']);
            }
            flash('success', 'Berita berhasil diperbarui.');
            $this->redirect('admin.articles.index');
        } catch (Throwable $exception) {
            if ($newImagePath !== null) {
                $uploadService->deleteIfUploaded($newImagePath);
            }
            error_log('Update article failed: ' . $exception->getMessage());
            flash('error', $exception instanceof \RuntimeException ? $exception->getMessage() : 'Berita gagal diperbarui.');
            $this->redirect('admin.articles.edit', ['id' => $articleId]);
        }
    }

    public function delete(): void
    {
        $this->requireAdmin();
        Csrf::requireValidRequest();
        $articleId = $this->validId($_POST['id'] ?? null);
        if (!$articleId) {
            flash('error', 'ID berita tidak valid.');
            $this->redirect('admin.articles.index');
        }
        $article = Article::find($articleId);
        if (!$article) {
            flash('error', 'Berita tidak ditemukan.');
            $this->redirect('admin.articles.index');
        }
        try {
            Article::delete($articleId);
            (new ImageUploadService())->deleteIfUploaded((string) $article['image_path']);
            flash('success', 'Berita dan komentar terkait berhasil dihapus.');
        } catch (Throwable $exception) {
            error_log('Delete article failed: ' . $exception->getMessage());
            flash('error', 'Berita gagal dihapus. Periksa log aplikasi.');
        }
        $this->redirect('admin.articles.index');
    }

    private function validateArticleInput(array $input): array
    {
        $title = trim(is_string($input['title'] ?? null) ? $input['title'] : '');
        $body = trim(is_string($input['body'] ?? null) ? $input['body'] : '');
        $categoryId = $this->validId($input['category_id'] ?? null);
        $publishedAt = trim(is_string($input['published_at'] ?? null) ? $input['published_at'] : '');
        if ($title === '' || text_length($title) > 255) {
            return [[], 'Judul wajib diisi dan maksimal 255 karakter.'];
        }
        if ($body === '') {
            return [[], 'Isi berita wajib diisi.'];
        }
        if (!$categoryId || !Category::find($categoryId)) {
            return [[], 'Pilih kategori yang valid.'];
        }
        if ($publishedAt !== '') {
            $date = strtotime($publishedAt);
            if ($date === false) {
                return [[], 'Tanggal publikasi tidak valid.'];
            }
            $publishedAt = date('Y-m-d H:i:s', $date);
        }
        return [[
            'title' => $title,
            'body' => $body,
            'category_id' => $categoryId,
            'published_at' => $publishedAt,
        ], null];
    }
}

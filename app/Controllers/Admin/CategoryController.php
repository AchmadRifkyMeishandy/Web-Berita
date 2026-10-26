<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Csrf;
use App\Models\Category;
use Throwable;

final class CategoryController extends Controller
{
    public function index(): void
    {
        $this->requireAdmin();
        $this->render('admin/categories/index', [
            'pageTitle' => 'Kelola Kategori',
            'categories' => Category::all(),
            'successMessage' => flash('success'),
            'errorMessage' => flash('error'),
        ], 'admin');
    }

    public function create(): void
    {
        $this->requireAdmin();
        $this->render('admin/categories/form', [
            'pageTitle' => 'Tambah Kategori', 'formAction' => url('admin.categories.store'),
            'category' => null, 'errorMessage' => flash('error'),
        ], 'admin');
    }

    public function store(): void
    {
        $this->requireAdmin();
        Csrf::requireValidRequest();
        $name = trim(is_string($_POST['name'] ?? null) ? $_POST['name'] : '');
        if ($name === '' || text_length($name) > 120) {
            flash('error', 'Nama kategori wajib diisi dan maksimal 120 karakter.');
            $this->redirect('admin.categories.create');
        }
        try {
            Category::create($name);
            flash('success', 'Kategori berhasil ditambahkan.');
            $this->redirect('admin.categories.index');
        } catch (Throwable $exception) {
            error_log('Create category failed: ' . $exception->getMessage());
            flash('error', 'Kategori gagal disimpan. Periksa apakah nama kategori sudah tersedia.');
            $this->redirect('admin.categories.create');
        }
    }

    public function edit(): void
    {
        $this->requireAdmin();
        $id = $this->validId($_GET['id'] ?? null);
        $category = $id ? Category::find($id) : null;
        if (!$category) {
            flash('error', 'Kategori tidak ditemukan.');
            $this->redirect('admin.categories.index');
        }
        $this->render('admin/categories/form', [
            'pageTitle' => 'Edit Kategori', 'formAction' => url('admin.categories.update', ['id' => $id]),
            'category' => $category, 'errorMessage' => flash('error'),
        ], 'admin');
    }

    public function update(): void
    {
        $this->requireAdmin();
        Csrf::requireValidRequest();
        $id = $this->validId($_GET['id'] ?? $_POST['id'] ?? null);
        $name = trim(is_string($_POST['name'] ?? null) ? $_POST['name'] : '');
        if (!$id || !Category::find($id)) {
            flash('error', 'Kategori tidak ditemukan.');
            $this->redirect('admin.categories.index');
        }
        if ($name === '' || text_length($name) > 120) {
            flash('error', 'Nama kategori wajib diisi dan maksimal 120 karakter.');
            $this->redirect('admin.categories.edit', ['id' => $id]);
        }
        try {
            Category::update($id, $name);
            flash('success', 'Kategori berhasil diperbarui.');
        } catch (Throwable $exception) {
            error_log('Update category failed: ' . $exception->getMessage());
            flash('error', 'Kategori gagal diperbarui.');
        }
        $this->redirect('admin.categories.index');
    }

    public function delete(): void
    {
        $this->requireAdmin();
        Csrf::requireValidRequest();
        $id = $this->validId($_POST['id'] ?? null);
        if (!$id) {
            flash('error', 'ID kategori tidak valid.');
            $this->redirect('admin.categories.index');
        }
        try {
            Category::delete($id);
            flash('success', 'Kategori berhasil dihapus.');
        } catch (Throwable $exception) {
            error_log('Delete category failed: ' . $exception->getMessage());
            flash('error', 'Kategori tidak dapat dihapus jika masih digunakan oleh artikel. Pindahkan artikel lebih dahulu.');
        }
        $this->redirect('admin.categories.index');
    }
}

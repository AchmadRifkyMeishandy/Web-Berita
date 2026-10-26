<section class="card admin-card admin-form-card admin-form-card--compact mb-4">
    <div class="card-header admin-card-header">
        <div>
            <h2><?= $category ? 'Perbarui kategori' : 'Buat kategori'; ?></h2>
            <p>Nama kategori digunakan untuk pengelompokan berita dan menu navigasi.</p>
        </div>
    </div>

    <div class="card-body">
        <form class="admin-form" action="<?= e($formAction); ?>" method="post">
            <?= csrf_input(); ?>

            <div class="admin-form-field">
                <label class="form-label" for="name">Nama kategori</label>
                <input
                    class="form-control"
                    id="name"
                    name="name"
                    maxlength="120"
                    value="<?= e($category['name'] ?? ''); ?>"
                    required
                >
            </div>

            <div class="admin-form-actions">
                <a class="btn btn-light" href="<?= e(url('admin.categories.index')); ?>">Batal</a>
                <button class="btn btn-primary" type="submit">
                    <?= $category ? 'Simpan perubahan' : 'Simpan kategori'; ?>
                </button>
            </div>
        </form>
    </div>
</section>

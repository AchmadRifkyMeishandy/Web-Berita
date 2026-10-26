<section class="card admin-card admin-form-card mb-4">
    <div class="card-header admin-card-header">
        <div>
            <h2><?= $article ? 'Perbarui artikel' : 'Isi artikel baru'; ?></h2>
            <p>Judul, kategori, isi, tanggal publikasi, dan gambar dikelola dari form ini.</p>
        </div>
    </div>

    <div class="card-body">
        <form
            class="admin-form"
            action="<?= e($formAction); ?>"
            method="post"
            enctype="multipart/form-data"
        >
            <?= csrf_input(); ?>

            <div class="admin-form-field">
                <label class="form-label" for="title">Judul berita</label>
                <input
                    class="form-control"
                    id="title"
                    name="title"
                    maxlength="255"
                    value="<?= e($article['title'] ?? ''); ?>"
                    required
                >
            </div>

            <div class="admin-form-field">
                <label class="form-label" for="category_id">Kategori</label>
                <select class="form-select" id="category_id" name="category_id" required>
                    <option value="">Pilih kategori</option>
                    <?php foreach ($categories as $category): ?>
                        <option
                            value="<?= (int) $category['id']; ?>"
                            <?= (int) ($article['category_id'] ?? 0) === (int) $category['id'] ? 'selected' : ''; ?>
                        >
                            <?= e($category['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if (!$categories): ?>
                    <div class="form-text">Buat kategori sebelum menambahkan berita.</div>
                <?php endif; ?>
            </div>

            <div class="admin-form-field">
                <label class="form-label" for="body">Isi berita</label>
                <textarea
                    class="form-control admin-textarea"
                    id="body"
                    name="body"
                    rows="12"
                    required
                ><?= e($article['body'] ?? ''); ?></textarea>
                <div class="form-text">Paragraf baru akan dipertahankan saat artikel ditampilkan.</div>
            </div>

            <div class="admin-form-field">
                <label class="form-label" for="published_at">Tanggal publikasi</label>
                <input
                    class="form-control"
                    id="published_at"
                    name="published_at"
                    type="datetime-local"
                    value="<?= e($article['published_input'] ?? ''); ?>"
                >
                <div class="form-text">Kosongkan untuk memakai tanggal dan waktu saat ini.</div>
            </div>

            <div class="admin-form-field">
                <label class="form-label" for="image">
                    Gambar berita <?= $article ? '(opsional jika tidak diganti)' : ''; ?>
                </label>
                <?php if ($article && !empty($article['image_path'])): ?>
                    <div class="admin-current-image mb-3">
                        <img src="<?= e(image_url($article['image_path'])); ?>" alt="Gambar berita saat ini">
                        <div>
                            <strong>Gambar saat ini</strong>
                            <span><?= e($article['image_path']); ?></span>
                        </div>
                    </div>
                <?php endif; ?>
                <input
                    class="form-control"
                    id="image"
                    name="image"
                    type="file"
                    accept="image/jpeg,image/png,image/webp"
                    <?= $article ? '' : 'required'; ?>
                >
                <div class="form-text">Format JPG, PNG, atau WEBP. Ukuran maksimal 5 MB.</div>
            </div>

            <div class="admin-form-actions">
                <a class="btn btn-light" href="<?= e(url('admin.articles.index')); ?>">Batal</a>
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-save me-2"></i>
                    <?= $article ? 'Simpan perubahan' : 'Simpan berita'; ?>
                </button>
            </div>
        </form>
    </div>
</section>

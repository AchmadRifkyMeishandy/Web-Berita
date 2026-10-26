<div class="card admin-card mb-4">
    <div class="card-header admin-card-header">
        <div>
            <h2>Daftar berita</h2>
            <p>Kelola artikel yang tampil di website publik.</p>
        </div>
        <a class="btn btn-primary" href="<?= e(url('admin.articles.create')); ?>">
            <i class="fas fa-plus me-2"></i>Tambah berita
        </a>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table admin-table admin-news-table" data-datatable>
                <thead>
                    <tr>
                        <th>Artikel</th>
                        <th>Kategori</th>
                        <th>Tanggal</th>
                        <th class="admin-actions-column">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($articles as $article): ?>
                        <tr>
                            <td>
                                <div class="admin-article-cell">
                                    <img
                                        class="admin-table-thumb"
                                        src="<?= e(image_url($article['image_path'])); ?>"
                                        alt=""
                                        loading="lazy"
                                    >
                                    <div class="admin-article-copy">
                                        <strong><?= e($article['title']); ?></strong>
                                        <p><?= e(text_excerpt((string) ($article['excerpt'] ?? ''), 120)); ?></p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="admin-category-pill">
                                    <?= e($article['category_name'] ?? 'Tanpa kategori'); ?>
                                </span>
                            </td>
                            <td class="admin-date-cell">
                                <?= e(format_date($article['published_at'])); ?>
                            </td>
                            <td class="admin-actions-cell">
                                <div class="admin-table-actions">
                                    <a
                                        class="btn btn-sm btn-outline-primary"
                                        href="<?= e(url('admin.articles.edit', ['id' => (int) $article['id']])); ?>"
                                    >Edit</a>
                                    <form
                                        method="post"
                                        action="<?= e(url('admin.articles.delete')); ?>"
                                        onsubmit="return confirm('Hapus berita ini beserta komentar terkait?');"
                                    >
                                        <?= csrf_input(); ?>
                                        <input type="hidden" name="id" value="<?= (int) $article['id']; ?>">
                                        <button class="btn btn-sm btn-outline-danger" type="submit">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <?php if (!$articles): ?>
                        <tr>
                            <td colspan="4">
                                <div class="admin-empty-state">
                                    <i class="fas fa-newspaper"></i>
                                    <strong>Belum ada berita</strong>
                                    <span>Tambahkan artikel pertama untuk memulai.</span>
                                    <a class="btn btn-primary" href="<?= e(url('admin.articles.create')); ?>">
                                        Tambah berita
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

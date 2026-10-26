<div class="card admin-card mb-4">
    <div class="card-header admin-card-header">
        <div>
            <h2>Daftar kategori</h2>
            <p>Kategori digunakan untuk mengelompokkan artikel.</p>
        </div>
        <a class="btn btn-primary" href="<?= e(url('admin.categories.create')); ?>">
            <i class="fas fa-plus me-2"></i>Tambah kategori
        </a>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table admin-table" data-datatable>
                <thead>
                    <tr>
                        <th>Kategori</th>
                        <th>Slug</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <td>
                                <div class="admin-category-name">
                                    <span class="admin-category-icon"><i class="fas fa-tag"></i></span>
                                    <strong><?= e($category['name']); ?></strong>
                                </div>
                            </td>
                            <td><?= e($category['slug']); ?></td>
                            <td class="admin-date-cell"><?= e(format_date($category['created_at'])); ?></td>
                            <td>
                                <div class="admin-table-actions">
                                    <a
                                        class="btn btn-sm btn-outline-primary"
                                        href="<?= e(url('admin.categories.edit', ['id' => (int) $category['id']])); ?>"
                                    >Edit</a>
                                    <form
                                        method="post"
                                        action="<?= e(url('admin.categories.delete')); ?>"
                                        onsubmit="return confirm('Hapus kategori ini? Kategori yang masih dipakai berita tidak dapat dihapus.');"
                                    >
                                        <?= csrf_input(); ?>
                                        <input type="hidden" name="id" value="<?= (int) $category['id']; ?>">
                                        <button class="btn btn-sm btn-outline-danger" type="submit">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <?php if (!$categories): ?>
                        <tr>
                            <td colspan="4">
                                <div class="admin-empty-state">
                                    <i class="fas fa-tags"></i>
                                    <strong>Belum ada kategori</strong>
                                    <span>Buat kategori terlebih dahulu.</span>
                                    <a class="btn btn-primary" href="<?= e(url('admin.categories.create')); ?>">
                                        Tambah kategori
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

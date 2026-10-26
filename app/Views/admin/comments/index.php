<section class="card admin-card mb-4">
    <div class="card-header admin-card-header">
        <div>
            <h2>Komentar pembaca</h2>
            <p>Hapus komentar yang melanggar aturan. Balasan terkait ikut dihapus saat komentar induk dihapus.</p>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table admin-table" data-datatable>
                <thead>
                    <tr>
                        <th>Pembaca</th>
                        <th>Komentar</th>
                        <th>Artikel</th>
                        <th>Balasan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($comments as $comment): ?>
                        <tr>
                            <td>
                                <strong><?= e($comment['name']); ?></strong>
                                <div class="admin-date-cell"><?= e(format_date($comment['created_at'])); ?></div>
                            </td>
                            <td class="admin-comment-cell">
                                <p><?= e($comment['body']); ?></p>
                            </td>
                            <td>
                                <a
                                    class="admin-article-title-small"
                                    href="<?= e(url('articles.show', ['id' => (int) $comment['article_id']])); ?>"
                                    target="_blank"
                                    rel="noopener"
                                ><?= e($comment['article_title']); ?></a>
                            </td>
                            <td><?= (int) $comment['reply_count']; ?></td>
                            <td>
                                <form
                                    method="post"
                                    action="<?= e(url('admin.comments.delete')); ?>"
                                    onsubmit="return confirm('Hapus komentar beserta balasannya?');"
                                >
                                    <?= csrf_input(); ?>
                                    <input type="hidden" name="comment_id" value="<?= (int) $comment['id']; ?>">
                                    <button class="btn btn-sm btn-outline-danger" type="submit">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <?php if (!$comments): ?>
                        <tr>
                            <td colspan="5">
                                <div class="admin-empty-state">
                                    <i class="fas fa-comments"></i>
                                    <strong>Belum ada komentar</strong>
                                    <span>Komentar pembaca akan muncul di sini.</span>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<section class="card admin-card mb-4">
    <div class="card-header admin-card-header">
        <div>
            <h2>Balasan komentar</h2>
            <p>Balasan ditautkan ke komentar induk dan artikel asal.</p>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table admin-table" data-datatable>
                <thead>
                    <tr>
                        <th>Penulis</th>
                        <th>Balasan</th>
                        <th>Konteks</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($replies as $reply): ?>
                        <tr>
                            <td>
                                <strong><?= e($reply['name']); ?></strong>
                                <div class="admin-date-cell"><?= e(format_date($reply['created_at'])); ?></div>
                            </td>
                            <td class="admin-comment-cell">
                                <p><?= e($reply['body']); ?></p>
                            </td>
                            <td>
                                <span class="admin-article-title-small">Balasan untuk <?= e($reply['comment_author']); ?></span>
                                <div class="admin-date-cell"><?= e($reply['article_title']); ?></div>
                            </td>
                            <td>
                                <form
                                    method="post"
                                    action="<?= e(url('admin.comments.delete')); ?>"
                                    onsubmit="return confirm('Hapus balasan ini?');"
                                >
                                    <?= csrf_input(); ?>
                                    <input type="hidden" name="reply_id" value="<?= (int) $reply['id']; ?>">
                                    <button class="btn btn-sm btn-outline-danger" type="submit">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <?php if (!$replies): ?>
                        <tr>
                            <td colspan="4">
                                <div class="admin-empty-state">
                                    <i class="fas fa-reply"></i>
                                    <strong>Belum ada balasan</strong>
                                    <span>Balasan komentar akan muncul di sini.</span>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

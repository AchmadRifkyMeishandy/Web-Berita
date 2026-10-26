<main class="news-article">
    <a class="news-article__back" href="<?= e(url('articles.index')); ?>">
        <i class="bi bi-arrow-left" aria-hidden="true"></i> Kembali ke daftar berita
    </a>

    <?php if (!$article): ?>
        <div class="news-empty">
            <h1>Berita tidak ditemukan</h1>
            <p>Tautan yang kamu buka tidak cocok dengan artikel yang tersedia.</p>
            <a class="news-read-link" href="<?= e(url('home')); ?>">Lihat berita terbaru</a>
        </div>
    <?php else: ?>
        <article>
            <header class="news-article__header">
                <span class="news-category"><?= e($article['category_name'] ?? 'Umum'); ?></span>
                <h1><?= e($article['title']); ?></h1>
                <div class="news-article__meta">
                    <i class="bi bi-calendar3" aria-hidden="true"></i>
                    <?= e(format_date($article['published_at'])); ?>
                </div>
            </header>

            <img
                class="news-article__cover"
                src="<?= e(image_url($article['image_path'])); ?>"
                alt="<?= e($article['title']); ?>"
                loading="eager"
            >

            <div class="news-article__content"><?= nl2br(e($article['body'])); ?></div>
        </article>

        <section class="news-comments" id="comments" aria-labelledby="comments-heading">
            <h2 id="comments-heading">Diskusi pembaca</h2>
            <p class="news-comments__intro">
                Sampaikan pendapat dengan sopan dan tetap menghargai pembaca lain.
            </p>

            <?php if (!empty($errorMessage)): ?>
                <div class="news-alert" role="alert"><p><?= e($errorMessage); ?></p></div>
            <?php endif; ?>
            <?php if (!empty($successMessage)): ?>
                <div class="news-alert" role="status"><p><?= e($successMessage); ?></p></div>
            <?php endif; ?>

            <form class="news-form" action="<?= e(url('comments.store')); ?>" method="post">
                <?= csrf_input(); ?>
                <input type="hidden" name="article_id" value="<?= (int) $article['id']; ?>">

                <label for="comment-name">Nama</label>
                <input
                    id="comment-name"
                    type="text"
                    name="name"
                    maxlength="120"
                    autocomplete="name"
                    required
                >

                <label for="comment-body">Komentar</label>
                <textarea
                    id="comment-body"
                    name="body"
                    maxlength="10000"
                    required
                    placeholder="Tulis komentarmu di sini..."
                ></textarea>

                <button type="submit">
                    <i class="bi bi-chat-dots" aria-hidden="true"></i> Kirim komentar
                </button>
            </form>

            <?php if ($comments): ?>
                <div class="news-comment-list">
                    <?php foreach ($comments as $comment): ?>
                        <article class="news-comment">
                            <div class="news-comment__top">
                                <strong><?= e($comment['name']); ?></strong>
                                <span class="news-comment__date">
                                    <?= e(format_date($comment['created_at'])); ?>
                                </span>
                            </div>
                            <p class="news-comment__text"><?= nl2br(e($comment['body'])); ?></p>

                            <?php foreach (($repliesByComment[(int) $comment['id']] ?? []) as $reply): ?>
                                <div class="news-comment__reply">
                                    <div class="news-comment__top">
                                        <strong><?= e($reply['name']); ?></strong>
                                        <span class="news-comment__date">
                                            <?= e(format_date($reply['created_at'])); ?>
                                        </span>
                                    </div>
                                    <p class="news-comment__text"><?= nl2br(e($reply['body'])); ?></p>
                                </div>
                            <?php endforeach; ?>

                            <form class="news-form news-form--reply" action="<?= e(url('replies.store')); ?>" method="post">
                                <?= csrf_input(); ?>
                                <input type="hidden" name="article_id" value="<?= (int) $article['id']; ?>">
                                <input type="hidden" name="comment_id" value="<?= (int) $comment['id']; ?>">

                                <label for="reply-name-<?= (int) $comment['id']; ?>">Nama untuk membalas</label>
                                <input
                                    id="reply-name-<?= (int) $comment['id']; ?>"
                                    type="text"
                                    name="name"
                                    maxlength="120"
                                    required
                                >

                                <label for="reply-body-<?= (int) $comment['id']; ?>">Balasan</label>
                                <textarea
                                    id="reply-body-<?= (int) $comment['id']; ?>"
                                    name="body"
                                    maxlength="10000"
                                    required
                                ></textarea>

                                <button type="submit">
                                    <i class="bi bi-reply" aria-hidden="true"></i> Balas komentar
                                </button>
                            </form>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="news-empty">
                    <h3>Belum ada komentar</h3>
                    <p>Jadilah pembaca pertama yang berdiskusi.</p>
                </div>
            <?php endif; ?>
        </section>
    <?php endif; ?>
</main>

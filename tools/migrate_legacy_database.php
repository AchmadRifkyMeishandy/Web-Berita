<?php

declare(strict_types=1);

use App\Core\Database;

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit("Jalankan migrasi ini melalui CLI, bukan browser.\n");
}

require dirname(__DIR__) . '/bootstrap.php';

function legacy_connection(): PDO
{
    $host = getenv('LEGACY_DB_HOST') ?: '127.0.0.1';
    $port = getenv('LEGACY_DB_PORT') ?: '3306';
    $database = getenv('LEGACY_DB_NAME') ?: 'beritaindonesia';
    $username = getenv('LEGACY_DB_USER') ?: 'root';
    $password = getenv('LEGACY_DB_PASSWORD') !== false ? getenv('LEGACY_DB_PASSWORD') : '';
    return new PDO(
        "mysql:host={$host};port={$port};dbname={$database};charset=utf8mb4",
        $username,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );
}

function legacy_date(?string $value): ?string
{
    $value = trim((string) $value);
    if ($value === '') {
        return null;
    }
    foreach (['!d F Y', '!j F Y', '!Y-m-d H:i:s', '!Y-m-d'] as $format) {
        $date = DateTimeImmutable::createFromFormat($format, $value, new DateTimeZone('Asia/Jakarta'));
        $errors = DateTimeImmutable::getLastErrors();
        if ($date && ($errors === false || ($errors['warning_count'] === 0 && $errors['error_count'] === 0))) {
            return $date->format('Y-m-d H:i:s');
        }
    }
    $timestamp = strtotime($value);
    return $timestamp === false ? null : date('Y-m-d H:i:s', $timestamp);
}

function report_line(string $message): void
{
    echo $message . PHP_EOL;
}

try {
    $sourceName = getenv('LEGACY_DB_NAME') ?: 'beritaindonesia';
    $targetName = getenv('DB_NAME') ?: 'beritaindonesia_mvc';
    if (strcasecmp($sourceName, $targetName) === 0) {
        throw new RuntimeException('Database sumber dan tujuan tidak boleh sama. Atur DB_NAME ke database MVC baru dan LEGACY_DB_NAME ke database lama.');
    }
    $source = legacy_connection();
    $target = Database::connection();

    $legacyCategories = $source->query('SELECT id_kategori, nama_kategori, tanggal_kategori FROM kategori ORDER BY id_kategori')->fetchAll();
    $legacyArticles = $source->query('SELECT id_berita, kode_kategori, judul_berita, isi_berita, tanggal_berita, gambar_berita FROM berita ORDER BY id_berita')->fetchAll();
    $legacyComments = $source->query('SELECT id_k, isi_k, tanggal_k, kode_berita, nama_k FROM komentar ORDER BY id_k')->fetchAll();
    $legacyReplies = $source->query('SELECT id_bk, nama_bk, isi_bk, tanggal_bk, kode_k, kode_berita FROM balaskomentar ORDER BY id_bk')->fetchAll();
    $legacyUsers = $source->query('SELECT id_user, username, password, level_user, nama_user, foto_user FROM users ORDER BY id_user')->fetchAll();

    // Lakukan audit relasi sebelum menulis data ke database tujuan.
    $categoryIds = array_fill_keys(array_map(static fn ($row) => (int) $row['id_kategori'], $legacyCategories), true);
    $articleIds = array_fill_keys(array_map(static fn ($row) => (int) $row['id_berita'], $legacyArticles), true);
    $commentsById = [];
    $issues = [];
    $categoryNamesSeen = [];
    foreach ($legacyCategories as $category) {
        if (legacy_date((string) $category['tanggal_kategori']) === null) {
            $issues[] = 'Tanggal kategori tidak dapat dikonversi untuk ID ' . $category['id_kategori'] . ': ' . $category['tanggal_kategori'];
        }
        $categoryName = trim((string) $category['nama_kategori']);
        $categoryNameKey = function_exists('mb_strtolower') ? mb_strtolower($categoryName, 'UTF-8') : strtolower($categoryName);
        if (isset($categoryNamesSeen[$categoryNameKey])) {
            $issues[] = 'Nama kategori duplikat: "' . $category['nama_kategori'] . '" pada ID ' . $categoryNamesSeen[$categoryNameKey] . ' dan ' . $category['id_kategori'];
        } else {
            $categoryNamesSeen[$categoryNameKey] = (int) $category['id_kategori'];
        }
    }
    foreach ($legacyArticles as $article) {
        if (legacy_date((string) $article['tanggal_berita']) === null) {
            $issues[] = 'Tanggal berita tidak dapat dikonversi untuk ID ' . $article['id_berita'] . ': ' . $article['tanggal_berita'];
        }
        if (!isset($categoryIds[(int) $article['kode_kategori']])) {
            $issues[] = 'Berita ID ' . $article['id_berita'] . ' menunjuk kategori yang tidak ditemukan: ' . $article['kode_kategori'];
        }
    }
    foreach ($legacyComments as $comment) {
        if (legacy_date((string) $comment['tanggal_k']) === null) {
            $issues[] = 'Tanggal komentar tidak dapat dikonversi untuk ID ' . $comment['id_k'] . ': ' . $comment['tanggal_k'];
        }
        $articleId = (int) $comment['kode_berita'];
        if (!isset($articleIds[$articleId])) {
            $issues[] = 'Komentar ID ' . $comment['id_k'] . ' menunjuk berita yang tidak ditemukan: ' . $comment['kode_berita'];
        }
        $commentsById[(int) $comment['id_k']] = $articleId;
    }
    foreach ($legacyReplies as $reply) {
        if (legacy_date((string) $reply['tanggal_bk']) === null) {
            $issues[] = 'Tanggal balasan tidak dapat dikonversi untuk ID ' . $reply['id_bk'] . ': ' . $reply['tanggal_bk'];
        }
        $commentId = (int) $reply['kode_k'];
        $articleId = (int) $reply['kode_berita'];
        if (!isset($commentsById[$commentId])) {
            $issues[] = 'Balasan ID ' . $reply['id_bk'] . ' menunjuk komentar yang tidak ditemukan: ' . $reply['kode_k'];
        } elseif ($commentsById[$commentId] !== $articleId) {
            $issues[] = 'Balasan ID ' . $reply['id_bk'] . ' mempunyai ID berita yang tidak sama dengan berita komentar induk.';
        }
    }
    if ($issues) {
        report_line('Migrasi dibatalkan sebelum penulisan karena ditemukan relasi yang perlu ditinjau:');
        foreach ($issues as $issue) {
            report_line('- ' . $issue);
        }
        report_line('Perbaiki data sumber atau simpan laporan ini untuk peninjauan, lalu jalankan kembali. Tidak ada data tujuan yang ditulis.');
        exit(2);
    }

    $targetCounts = [];
    foreach (['users', 'categories', 'articles', 'comments', 'comment_replies'] as $table) {
        $targetCounts[$table] = (int) $target->query('SELECT COUNT(*) FROM `' . $table . '`')->fetchColumn();
    }
    if (array_sum($targetCounts) > 0) {
        throw new RuntimeException('Database tujuan tidak kosong. Migrator berhenti untuk mencegah duplikasi. Gunakan database tujuan kosong yang sudah diimpor dengan database/schema.sql.');
    }

    // Slug kategori unik walaupun nama kategori lama berulang.
    $usedCategorySlugs = [];
    $categoryRows = [];
    foreach ($legacyCategories as $row) {
        $slugBase = slugify((string) $row['nama_kategori']) ?: 'kategori';
        $slug = $slugBase;
        $suffix = 2;
        while (isset($usedCategorySlugs[$slug])) {
            $slug = $slugBase . '-' . $suffix++;
        }
        $usedCategorySlugs[$slug] = true;
        $categoryRows[] = [
            'id' => (int) $row['id_kategori'],
            'name' => trim((string) $row['nama_kategori']),
            'slug' => $slug,
            'created_at' => legacy_date($row['tanggal_kategori']) ?? date('Y-m-d H:i:s'),
        ];
    }

    $usedArticleSlugs = [];
    $articleRows = [];
    foreach ($legacyArticles as $row) {
        $slugBase = slugify((string) $row['judul_berita']) ?: 'artikel-' . (int) $row['id_berita'];
        $slug = $slugBase;
        $suffix = 2;
        while (isset($usedArticleSlugs[$slug])) {
            $slug = $slugBase . '-' . $suffix++;
        }
        $usedArticleSlugs[$slug] = true;
        $imageName = basename((string) $row['gambar_berita']);
        if ($imageName === '' || $imageName === '.' || $imageName === '..') {
            $imageName = 'news-placeholder.svg';
        }
        $articleRows[] = [
            'id' => (int) $row['id_berita'],
            'category_id' => (int) $row['kode_kategori'],
            'title' => trim((string) $row['judul_berita']),
            'slug' => $slug,
            'body' => (string) $row['isi_berita'],
            'image_path' => $imageName,
            'published_at' => legacy_date($row['tanggal_berita']),
        ];
    }

    $legacyImageDirectory = trim((string) (getenv('LEGACY_IMAGE_DIR') ?: ''));
    if ($legacyImageDirectory === '') {
        $legacyImageDirectory = dirname(__DIR__) . '/public/assets/images';
    }
    $targetImageDirectory = dirname(__DIR__) . '/public/assets/images';
    foreach ($articleRows as $article) {
        $fileName = basename($article['image_path']);
        $sourceImage = rtrim($legacyImageDirectory, '/\\') . DIRECTORY_SEPARATOR . $fileName;
        $targetImage = $targetImageDirectory . DIRECTORY_SEPARATOR . $fileName;
        if (!is_file($targetImage) && is_file($sourceImage)) {
            if (!copy($sourceImage, $targetImage)) {
                throw new RuntimeException('Gagal menyalin gambar legacy: ' . $fileName);
            }
        }
    }

    $target->beginTransaction();
    $insertCategory = $target->prepare('INSERT INTO categories (id, name, slug, created_at) VALUES (:id, :name, :slug, :created_at)');
    foreach ($categoryRows as $row) {
        $insertCategory->execute($row);
    }

    $insertArticle = $target->prepare('INSERT INTO articles (id, category_id, title, slug, body, image_path, published_at) VALUES (:id, :category_id, :title, :slug, :body, :image_path, :published_at)');
    foreach ($articleRows as $row) {
        $insertArticle->execute($row);
    }

    $insertComment = $target->prepare('INSERT INTO comments (id, article_id, name, body, created_at) VALUES (:id, :article_id, :name, :body, :created_at)');
    foreach ($legacyComments as $row) {
        $insertComment->execute([
            'id' => (int) $row['id_k'],
            'article_id' => (int) $row['kode_berita'],
            'name' => (string) $row['nama_k'],
            'body' => (string) $row['isi_k'],
            'created_at' => legacy_date($row['tanggal_k']) ?? date('Y-m-d H:i:s'),
        ]);
    }

    $insertReply = $target->prepare('INSERT INTO comment_replies (id, comment_id, name, body, created_at) VALUES (:id, :comment_id, :name, :body, :created_at)');
    foreach ($legacyReplies as $row) {
        $insertReply->execute([
            'id' => (int) $row['id_bk'],
            'comment_id' => (int) $row['kode_k'],
            'name' => (string) $row['nama_bk'],
            'body' => (string) $row['isi_bk'],
            'created_at' => legacy_date($row['tanggal_bk']) ?? date('Y-m-d H:i:s'),
        ]);
    }

    $insertUser = $target->prepare('INSERT INTO users (id, username, password_hash, role, full_name, profile_photo) VALUES (:id, :username, :password_hash, :role, :full_name, :profile_photo)');
    foreach ($legacyUsers as $row) {
        $storedPassword = (string) $row['password'];
        $passwordInfo = password_get_info($storedPassword);
        if (($passwordInfo['algoName'] ?? 'unknown') === 'unknown') {
            $storedPassword = password_hash($storedPassword, PASSWORD_DEFAULT);
        }
        $role = in_array($row['level_user'], ['admin', 'member'], true) ? $row['level_user'] : 'member';
        $insertUser->execute([
            'id' => (int) $row['id_user'],
            'username' => (string) $row['username'],
            'password_hash' => $storedPassword,
            'role' => $role,
            'full_name' => (string) $row['nama_user'],
            'profile_photo' => (($row['foto_user'] ?? '') === '' ? null : (string) $row['foto_user']),
        ]);
    }

    $target->commit();
    $summary = [
        'migrated_at' => date(DATE_ATOM),
        'categories' => count($categoryRows),
        'articles' => count($articleRows),
        'comments' => count($legacyComments),
        'comment_replies' => count($legacyReplies),
        'users' => count($legacyUsers),
        'status' => 'success',
    ];
    $reportDirectory = dirname(__DIR__) . '/storage/logs';
    if (!is_dir($reportDirectory)) {
        mkdir($reportDirectory, 0775, true);
    }
    file_put_contents($reportDirectory . '/legacy-migration-report.json', json_encode($summary, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    report_line('Migrasi berhasil. Ringkasan:');
    foreach ($summary as $name => $value) {
        report_line('- ' . $name . ': ' . $value);
    }
    report_line('Database sumber tidak diubah. Semua data sumber tetap ada di database lama.');
} catch (Throwable $exception) {
    if (isset($target) && $target instanceof PDO && $target->inTransaction()) {
        $target->rollBack();
    }
    fwrite(STDERR, 'Migrasi gagal: ' . $exception->getMessage() . PHP_EOL);
    exit(1);
}

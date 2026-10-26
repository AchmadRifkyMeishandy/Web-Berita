<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Baca kabar dan perspektif dari berbagai kategori berita Indonesia.">
    <title><?= e($pageTitle ?? 'Berita Indonesia'); ?></title>
    <link rel="icon" type="image/x-icon" href="<?= e(asset('favicon.ico')); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= e(asset('css/news-modern.css')); ?>" rel="stylesheet">
</head>
<body>
    <?php require dirname(__DIR__) . '/partials/public-header.php'; ?>
    <?= $content; ?>
    <?php require dirname(__DIR__) . '/partials/public-footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <?php if (($_GET['section'] ?? '') === 'comments'): ?>
        <script>document.getElementById('comments')?.scrollIntoView({ behavior: 'smooth' });</script>
    <?php endif; ?>
</body>
</html>

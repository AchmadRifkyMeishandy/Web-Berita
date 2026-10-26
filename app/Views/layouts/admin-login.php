<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle ?? 'Login Admin'); ?></title>
    <link rel="icon" href="<?= e(asset('favicon.ico')); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= e(asset('admin/styles.css')); ?>" rel="stylesheet">
    <link href="<?= e(asset('admin/news-admin-modern.css')); ?>" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
</head>
<body class="admin-login-page">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main class="container">
                <?= $content; ?>
            </main>
        </div>
    </div>
</body>
</html>

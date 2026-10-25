<?php
session_start();

if (!empty($_SESSION['admin'])) {
    header('Location: index.php');
    exit;
}

function admin_h($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$notice = '';
$noticeType = 'warning';
if (isset($_GET['notif'])) {
    if ($_GET['notif'] === 'invalid') {
        $notice = 'Username atau password tidak sesuai.';
    } elseif ($_GET['notif'] === 'error') {
        $notice = 'Login belum dapat diproses. Silakan coba lagi.';
    }
}
$username = isset($_GET['username']) && is_string($_GET['username']) ? $_GET['username'] : '';
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin — Berita Indonesia</title>
    <link href="css/styles.css" rel="stylesheet">
</head>
<body class="admin-login-page">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h1 class="text-center font-weight-light my-4 h3">Login Admin</h1>
                                </div>
                                <div class="card-body">
                                    <?php if ($notice !== ''): ?>
                                        <div class="alert alert-<?= admin_h($noticeType); ?>" role="alert"><?= admin_h($notice); ?></div>
                                    <?php endif; ?>
                                    <form method="POST" action="../controllers/login_admin.php" autocomplete="on">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" required name="username" value="<?= admin_h($username); ?>" id="inputUsername" type="text" autocomplete="username" placeholder="Username">
                                            <label for="inputUsername">Username</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" required name="password" id="inputPassword" type="password" autocomplete="current-password" placeholder="Password">
                                            <label for="inputPassword">Password</label>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-end mt-4 mb-0">
                                            <button class="btn btn-primary" type="submit">Masuk</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small text-muted">Halaman administrasi Berita Indonesia</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="small text-center text-muted">Berita Indonesia &copy; <?= date('Y'); ?></div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
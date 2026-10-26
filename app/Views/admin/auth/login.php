<div class="row justify-content-center">
    <div class="col-lg-5 col-md-7">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header text-center">
                <div class="admin-brand-mark mx-auto mb-3">BI</div>
                <h1 class="h3 mb-1">Berita Indonesia</h1>
                <p class="text-muted mb-0">Masuk ke panel administrasi</p>
            </div>

            <div class="card-body">
                <?php if (!empty($errorMessage)): ?>
                    <div class="alert alert-danger" role="alert"><?= e($errorMessage); ?></div>
                <?php endif; ?>
                <?php if ($notice = flash('success')): ?>
                    <div class="alert alert-success" role="status"><?= e($notice); ?></div>
                <?php endif; ?>

                <form method="post" action="<?= e(url('admin.login')); ?>">
                    <?= csrf_input(); ?>
                    <div class="form-floating mb-3">
                        <input
                            class="form-control"
                            id="username"
                            name="username"
                            type="text"
                            autocomplete="username"
                            required
                            autofocus
                            placeholder="Username"
                        >
                        <label for="username">Username</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input
                            class="form-control"
                            id="password"
                            name="password"
                            type="password"
                            autocomplete="current-password"
                            required
                            placeholder="Password"
                        >
                        <label for="password">Password</label>
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Masuk</button>
                </form>
            </div>

            <div class="card-footer text-center py-3">
                <a href="<?= e(url('home')); ?>">Kembali ke website</a>
            </div>
        </div>
    </div>
</div>

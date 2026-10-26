<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Csrf;
use App\Models\User;

final class AuthController extends Controller
{
    public function login(): void
    {
        if (!empty($_SESSION['admin_id']) && ($_SESSION['admin_role'] ?? '') === 'admin') {
            $this->redirect('admin.dashboard');
        }
        $this->render('admin/auth/login', [
            'pageTitle' => 'Login Admin — Berita Indonesia',
            'errorMessage' => flash('error'),
        ], 'admin-login');
    }

    public function authenticate(): void
    {
        Csrf::requireValidRequest();
        $username = trim(is_string($_POST['username'] ?? null) ? $_POST['username'] : '');
        $password = is_string($_POST['password'] ?? null) ? $_POST['password'] : '';
        $user = $username !== '' ? User::findByUsername($username) : null;

        if (!$user || $user['role'] !== 'admin' || !password_verify($password, (string) $user['password_hash'])) {
            flash('error', 'Username atau password tidak sesuai.');
            $this->redirect('admin.login');
        }

        session_regenerate_id(true);
        $_SESSION['admin_id'] = (int) $user['id'];
        $_SESSION['admin_role'] = (string) $user['role'];
        $_SESSION['admin_name'] = (string) $user['full_name'];
        flash('success', 'Berhasil masuk ke panel admin.');
        $this->redirect('admin.dashboard');
    }

    public function logout(): void
    {
        Csrf::requireValidRequest();
        unset($_SESSION['admin_id'], $_SESSION['admin_role'], $_SESSION['admin_name']);
        session_regenerate_id(true);
        flash('success', 'Kamu sudah keluar dari panel admin.');
        $this->redirect('admin.login');
    }
}

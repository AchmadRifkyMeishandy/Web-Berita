<?php
session_start();
require_once __DIR__ . '/connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../admin/login.php');
    exit;
}

$usernameInput = $_POST['username'] ?? '';
$passwordInput = $_POST['password'] ?? '';
$username = is_string($usernameInput) ? trim($usernameInput) : '';
$password = is_string($passwordInput) ? $passwordInput : '';

if ($username === '' || $password === '') {
    header('Location: ../admin/login.php?notif=invalid');
    exit;
}

$statement = mysqli_prepare(
    $db,
    'SELECT id_user, username, password, level_user, nama_user
     FROM users
     WHERE username = ?
     LIMIT 1'
);

if (!$statement) {
    error_log('Could not prepare admin login query.');
    header('Location: ../admin/login.php?notif=error');
    exit;
}

mysqli_stmt_bind_param($statement, 's', $username);
mysqli_stmt_execute($statement);
$result = mysqli_stmt_get_result($statement);
$user = $result ? mysqli_fetch_assoc($result) : null;
mysqli_stmt_close($statement);

if (!$user || $user['level_user'] !== 'admin') {
    header('Location: ../admin/login.php?notif=invalid');
    exit;
}

$storedPassword = (string) $user['password'];
$passwordValid = password_verify($password, $storedPassword);
$legacyPlaintextPassword = false;

// Transitional support for old local databases that stored plaintext passwords.
// A successful legacy login upgrades the stored value to a password hash.
if (!$passwordValid && $storedPassword !== '' && hash_equals($storedPassword, $password)) {
    $passwordValid = true;
    $legacyPlaintextPassword = true;
}

if (!$passwordValid) {
    header('Location: ../admin/login.php?notif=invalid');
    exit;
}

if ($legacyPlaintextPassword) {
    $newHash = password_hash($password, PASSWORD_DEFAULT);
    $updateStatement = mysqli_prepare($db, 'UPDATE users SET password = ? WHERE id_user = ?');
    if ($updateStatement) {
        $userId = (int) $user['id_user'];
        mysqli_stmt_bind_param($updateStatement, 'si', $newHash, $userId);
        mysqli_stmt_execute($updateStatement);
        mysqli_stmt_close($updateStatement);
    }
}

session_regenerate_id(true);
$_SESSION['admin'] = (int) $user['id_user'];
$_SESSION['admin_name'] = (string) $user['nama_user'];

header('Location: ../admin/index.php');
exit;

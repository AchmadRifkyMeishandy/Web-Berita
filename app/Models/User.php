<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

final class User
{
    public static function findByUsername(string $username): ?array
    {
        $statement = Database::connection()->prepare(
            'SELECT id, username, password_hash, role, full_name FROM users WHERE username = :username LIMIT 1'
        );
        $statement->execute(['username' => trim($username)]);
        $user = $statement->fetch();
        return $user ?: null;
    }

    public static function countAll(): int
    {
        return (int) Database::connection()->query('SELECT COUNT(*) FROM users')->fetchColumn();
    }
}

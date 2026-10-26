<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

final class Category
{
    public static function all(): array
    {
        return Database::connection()->query(
            'SELECT id, name, slug, created_at FROM categories ORDER BY name ASC'
        )->fetchAll();
    }

    public static function countAll(): int
    {
        return (int) Database::connection()->query('SELECT COUNT(*) FROM categories')->fetchColumn();
    }

    public static function find(int $id): ?array
    {
        $statement = Database::connection()->prepare('SELECT id, name, slug, created_at FROM categories WHERE id = :id LIMIT 1');
        $statement->execute(['id' => $id]);
        $category = $statement->fetch();
        return $category ?: null;
    }

    public static function create(string $name): int
    {
        $name = trim($name);
        $slug = self::uniqueSlug($name);
        $statement = Database::connection()->prepare('INSERT INTO categories (name, slug) VALUES (:name, :slug)');
        $statement->execute(['name' => $name, 'slug' => $slug]);
        return (int) Database::connection()->lastInsertId();
    }

    public static function update(int $id, string $name): bool
    {
        $statement = Database::connection()->prepare('UPDATE categories SET name = :name, slug = :slug WHERE id = :id');
        return $statement->execute(['name' => trim($name), 'slug' => self::uniqueSlug(trim($name), $id), 'id' => $id]);
    }

    public static function delete(int $id): void
    {
        $statement = Database::connection()->prepare('DELETE FROM categories WHERE id = :id');
        $statement->execute(['id' => $id]);
    }

    private static function uniqueSlug(string $value, ?int $exceptId = null): string
    {
        $base = slugify($value) ?: 'kategori';
        $candidate = $base;
        $suffix = 2;
        $pdo = Database::connection();
        while (true) {
            $sql = 'SELECT id FROM categories WHERE slug = :slug';
            $parameters = ['slug' => $candidate];
            if ($exceptId !== null) {
                $sql .= ' AND id <> :except_id';
                $parameters['except_id'] = $exceptId;
            }
            $sql .= ' LIMIT 1';
            $statement = $pdo->prepare($sql);
            $statement->execute($parameters);
            if (!$statement->fetch()) {
                return $candidate;
            }
            $candidate = $base . '-' . $suffix++;
        }
    }
}

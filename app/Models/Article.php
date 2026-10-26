<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

final class Article
{
    public static function countAll(?int $categoryId = null): int
    {
        $pdo = Database::connection();
        if ($categoryId !== null) {
            $statement = $pdo->prepare('SELECT COUNT(*) FROM articles WHERE category_id = :category_id');
            $statement->execute(['category_id' => $categoryId]);
            return (int) $statement->fetchColumn();
        }
        return (int) $pdo->query('SELECT COUNT(*) FROM articles')->fetchColumn();
    }

    public static function latest(int $limit = 6): array
    {
        $limit = max(1, min(24, $limit));

        $statement = Database::connection()->query(
            'SELECT a.id, a.category_id, a.title, a.slug, LEFT(a.body, 800) AS body, a.image_path, a.published_at,
                    c.name AS category_name, c.slug AS category_slug
             FROM articles AS a
             LEFT JOIN categories AS c ON c.id = a.category_id
             ORDER BY a.published_at DESC, a.id DESC
             LIMIT ' . $limit
        );

        return $statement->fetchAll();
    }

    public static function paginate(?int $categoryId, int $page, int $perPage = 9): array
    {
        $page = max(1, $page);
        $perPage = max(1, min(50, $perPage));
        $total = self::countAll($categoryId);
        $totalPages = max(1, (int) ceil($total / $perPage));
        $page = min($page, $totalPages);
        $offset = ($page - 1) * $perPage;
        $sql = 'SELECT a.id, a.category_id, a.title, a.slug, LEFT(a.body, 800) AS excerpt,
                       a.image_path, a.published_at, c.name AS category_name, c.slug AS category_slug
                FROM articles AS a
                LEFT JOIN categories AS c ON c.id = a.category_id';
        $parameters = [];
        if ($categoryId !== null) {
            $sql .= ' WHERE a.category_id = :category_id';
            $parameters['category_id'] = $categoryId;
        }
        $sql .= ' ORDER BY a.published_at DESC, a.id DESC LIMIT :limit OFFSET :offset';
        $statement = Database::connection()->prepare($sql);
        foreach ($parameters as $key => $value) {
            $statement->bindValue(':' . $key, $value, PDO::PARAM_INT);
        }
        $statement->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
        $statement->execute();

        return [
            'articles' => $statement->fetchAll(),
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage,
            'totalPages' => $totalPages,
        ];
    }

    public static function find(int $id): ?array
    {
        $statement = Database::connection()->prepare(
            'SELECT a.id, a.category_id, a.title, a.slug, a.body, a.image_path, a.published_at,
                    c.name AS category_name, c.slug AS category_slug
             FROM articles AS a
             LEFT JOIN categories AS c ON c.id = a.category_id
             WHERE a.id = :id LIMIT 1'
        );
        $statement->execute(['id' => $id]);
        $article = $statement->fetch();
        return $article ?: null;
    }

    public static function allForAdmin(): array
    {
        return Database::connection()->query(
            'SELECT a.id, a.title, a.slug, LEFT(a.body, 240) AS excerpt, a.image_path, a.published_at,
                    c.name AS category_name
             FROM articles AS a
             LEFT JOIN categories AS c ON c.id = a.category_id
             ORDER BY a.id DESC'
        )->fetchAll();
    }

    public static function create(array $data): int
    {
        $pdo = Database::connection();
        $slug = self::uniqueSlug((string) $data['title']);
        $statement = $pdo->prepare(
            'INSERT INTO articles (category_id, title, slug, body, image_path, published_at)
             VALUES (:category_id, :title, :slug, :body, :image_path, :published_at)'
        );
        $statement->execute([
            'category_id' => (int) $data['category_id'],
            'title' => trim((string) $data['title']),
            'slug' => $slug,
            'body' => trim((string) $data['body']),
            'image_path' => (string) $data['image_path'],
            'published_at' => $data['published_at'] ?: date('Y-m-d H:i:s'),
        ]);
        return (int) $pdo->lastInsertId();
    }

    public static function update(int $id, array $data): void
    {
        $statement = Database::connection()->prepare(
            'UPDATE articles
             SET category_id = :category_id, title = :title, slug = :slug,
                 body = :body, image_path = :image_path, published_at = :published_at
             WHERE id = :id'
        );
        $statement->execute([
            'category_id' => (int) $data['category_id'],
            'title' => trim((string) $data['title']),
            'slug' => self::uniqueSlug((string) $data['title'], $id),
            'body' => trim((string) $data['body']),
            'image_path' => (string) $data['image_path'],
            'published_at' => $data['published_at'] ?: date('Y-m-d H:i:s'),
            'id' => $id,
        ]);
    }

    public static function delete(int $id): void
    {
        $statement = Database::connection()->prepare('DELETE FROM articles WHERE id = :id');
        $statement->execute(['id' => $id]);
    }

    private static function uniqueSlug(string $title, ?int $exceptId = null): string
    {
        $base = slugify($title) ?: 'artikel';
        $candidate = $base;
        $suffix = 2;
        $pdo = Database::connection();
        while (true) {
            $sql = 'SELECT id FROM articles WHERE slug = :slug';
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

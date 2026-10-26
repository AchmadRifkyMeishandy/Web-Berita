<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

final class Comment
{
    public static function forArticle(int $articleId): array
    {
        $statement = Database::connection()->prepare(
            'SELECT id, article_id, name, body, created_at
             FROM comments WHERE article_id = :article_id ORDER BY id DESC'
        );
        $statement->execute(['article_id' => $articleId]);
        return $statement->fetchAll();
    }

    public static function repliesForArticle(int $articleId): array
    {
        $statement = Database::connection()->prepare(
            'SELECT r.id, r.comment_id, r.name, r.body, r.created_at
             FROM comment_replies AS r
             INNER JOIN comments AS c ON c.id = r.comment_id
             WHERE c.article_id = :article_id
             ORDER BY r.id ASC'
        );
        $statement->execute(['article_id' => $articleId]);
        return $statement->fetchAll();
    }

    public static function allForAdmin(): array
    {
        return Database::connection()->query(
            'SELECT c.id, c.name, c.body, c.created_at, a.id AS article_id, a.title AS article_title,
                    (SELECT COUNT(*) FROM comment_replies r WHERE r.comment_id = c.id) AS reply_count
             FROM comments c
             INNER JOIN articles a ON a.id = c.article_id
             ORDER BY c.id DESC'
        )->fetchAll();
    }

    public static function allRepliesForAdmin(): array
    {
        return Database::connection()->query(
            'SELECT r.id, r.name, r.body, r.created_at, c.id AS comment_id,
                    c.name AS comment_author, a.title AS article_title
             FROM comment_replies r
             INNER JOIN comments c ON c.id = r.comment_id
             INNER JOIN articles a ON a.id = c.article_id
             ORDER BY r.id DESC'
        )->fetchAll();
    }

    public static function create(int $articleId, string $name, string $body): void
    {
        $statement = Database::connection()->prepare(
            'INSERT INTO comments (article_id, name, body) VALUES (:article_id, :name, :body)'
        );
        $statement->execute(['article_id' => $articleId, 'name' => trim($name), 'body' => trim($body)]);
    }

    public static function createReply(int $commentId, string $name, string $body): void
    {
        $statement = Database::connection()->prepare(
            'INSERT INTO comment_replies (comment_id, name, body) VALUES (:comment_id, :name, :body)'
        );
        $statement->execute(['comment_id' => $commentId, 'name' => trim($name), 'body' => trim($body)]);
    }

    public static function findForArticle(int $commentId, int $articleId): ?array
    {
        $statement = Database::connection()->prepare(
            'SELECT id FROM comments WHERE id = :id AND article_id = :article_id LIMIT 1'
        );
        $statement->execute(['id' => $commentId, 'article_id' => $articleId]);
        $comment = $statement->fetch();
        return $comment ?: null;
    }

    public static function delete(int $id): void
    {
        $statement = Database::connection()->prepare('DELETE FROM comments WHERE id = :id');
        $statement->execute(['id' => $id]);
    }

    public static function deleteReply(int $id): void
    {
        $statement = Database::connection()->prepare('DELETE FROM comment_replies WHERE id = :id');
        $statement->execute(['id' => $id]);
    }
}

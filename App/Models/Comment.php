<?php

namespace App\Models;

final class Comment extends Model
{
    protected string $table = "comments";

    public function findAllByArticle(int $articleId): array
    {
        $query = $this->pdo->prepare(
            "SELECT * FROM comments WHERE article_id = :article_id ORDER BY created_at DESC"
        );
        $query->execute(['article_id' => $articleId]);

        return $query->fetchAll();
    }

    public function insert(string $author, string $content, int $articleId): void
    {
        $query = $this->pdo->prepare(
            "INSERT INTO comments (author, content, article_id, created_at)
             VALUES (:author, :content, :article_id, NOW())"
        );
        $query->execute([
            'author' => $author,
            'content' => $content,
            'article_id' => $articleId
        ]);
    }
}

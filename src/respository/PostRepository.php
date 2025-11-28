<?php

namespace App\Repository;

use PDO;

class PostRepository
{
    public function __construct(private PDO $db) {}

    public function findByFeed(int $feedId, int $limit): array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM posts WHERE feed_id = ? ORDER BY id LIMIT ?"
        );
        $stmt->execute([$feedId, $limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert(int $newFeedId, array $post): void
    {
        $stmt = $this->db->prepare(
            "INSERT INTO posts (feed_id, url) VALUES (?, ?)"
        );
        $stmt->execute([
            $newFeedId,
            $post['url'],
        ]);
    }
}

<?php

namespace App\Repository;

use PDO;

class InstagramSourceRepository
{
    public function __construct(private PDO $db) {}

    public function find(int $feedId): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM instagram_sources WHERE feed_id = ?"
        );
        $stmt->execute([$feedId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function insert(int $newFeedId, array $row): void
    {
        $stmt = $this->db->prepare(
            "INSERT INTO instagram_sources (feed_id, name, fan_count)
             VALUES (?, ?, ?)"
        );
        $stmt->execute([
            $newFeedId,
            $row['name'],
            $row['fan_count'],
        ]);
    }
}

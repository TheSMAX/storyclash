<?php
namespace App\Repository;

use PDO;

class TikTokSourceRepository
{
    public function __construct(private PDO $db)
    {
        $this->db = $db;
    }

    public function find(int $feedId): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM tiktok_sources WHERE feed_id = ?'
        );
        $stmt->execute([$feedId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function insert(int $newFeedId, array $data): void
    {
        $stmt = $this->db->prepare(
            'INSERT INTO tiktok_sources (feed_id, name, fan_count) VALUES (?, ?, ?)'
        );
        $stmt->execute([$newFeedId, $data['name'], $data['fan_count'],]);
    }
}
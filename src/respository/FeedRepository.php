<?php

namespace App\Repository;

use PDO;

class FeedRepository
{
    public function __construct(private PDO $db) {}

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM feeds WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function insert(array $feed): int
    {
        $stmt = $this->db->prepare("INSERT INTO feeds (name) VALUES (?)");
        $stmt->execute([$feed['name']]);
        return (int)$this->db->lastInsertId();
    }
}

<?php

use App\Service\FeedCopyService;
use App\Database;
use PHPUnit\Framework\TestCase;

class FeedCopyServiceTest extends TestCase
{
    protected function setUp(): void
    {
        $db = new PDO('sqlite::memory:');
        $db->exec("CREATE TABLE feeds (id INTEGER PRIMARY KEY, name TEXT)");
        $db->exec("CREATE TABLE instagram_sources (feed_id INTEGER, name TEXT, fan_count INTEGER)");
        $db->exec("CREATE TABLE tiktok_sources (feed_id INTEGER, name TEXT, fan_count INTEGER)");
        $db->exec("CREATE TABLE posts (id INTEGER PRIMARY KEY, feed_id INTEGER, url TEXT)");

        // inject sqlite database
        Database::override($db);

        // insert base feed
        $db->exec("INSERT INTO feeds (id, name) VALUES (1, 'Test')");
        $db->exec("INSERT INTO instagram_sources VALUES (1, 'acc', 100)");
        $db->exec("INSERT INTO posts (feed_id, url) VALUES (1, 'url1')");
    }

    public function testCopyCreatesNewFeed()
    {
        $service = new FeedCopyService();

        $newId = $service->copyFeed(1, 'instagram', 1);

        $db = Database::instance()->connection;

        $name = $db->query("SELECT name FROM feeds WHERE id = {$newId}")
                  ->fetchColumn();

        $this->assertStringContainsString('(copy)', $name);
    }
}

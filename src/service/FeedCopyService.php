<?php

namespace App\Service;

use App\Database;
use App\Repository\FeedRepository;
use App\Repository\InstagramSourceRepository;
use App\Repository\TikTokSourceRepository;
use App\Repository\PostRepository;

class FeedCopyService
{
    private FeedRepository $feeds;
    private InstagramSourceRepository $insta;
    private TikTokSourceRepository $tiktok;
    private PostRepository $posts;

    public function __construct()
    {
        $db = (new Database())->connection;

        $this->feeds = new FeedRepository($db);
        $this->insta = new InstagramSourceRepository($db);
        $this->tiktok = new TikTokSourceRepository($db);
        $this->posts = new PostRepository($db);
    }

    public function copyFeed(int $feedId, ?string $only, int $postsLimit): int
    {
        $feed = $this->feeds->find($feedId);
        if (!$feed) {
            throw new \RuntimeException("Feed {$feedId} does not exist");
        }

        // 1) copy base feed
        $newFeedId = $this->feeds->insert([
            'name' => $feed['name'] . ' (copy)',
        ]);

        // 2) copy sources
        if ($only === null || $only === 'instagram') {
            $src = $this->insta->find($feedId);
            if ($src) {
                $this->insta->insert($newFeedId, $src);
            }
        }

        if ($only === null || $only === 'tiktok') {
            $src = $this->tiktok->find($feedId);
            if ($src) {
                $this->tiktok->insert($newFeedId, $src);
            }
        }

        // 3) copy posts
        if ($postsLimit > 0) {
            $posts = $this->posts->findByFeed($feedId, $postsLimit);
            foreach ($posts as $post) {
                $this->posts->insert($newFeedId, $post);
            }
        }

        return $newFeedId;
    }
}

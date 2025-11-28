<?php

namespace App\Command;

use App\Service\FeedCopyService;

class CopyFeedCommand
{
    public function run(array $argv): void
    {
        array_shift($argv); // remove script name

        $options = [
            'only' => null,
            'include-posts' => 0,
        ];

        // parse options
        foreach ($argv as $key => $arg) {
            if (str_starts_with($arg, '--only=')) {
                $options['only'] = substr($arg, 7);
                unset($argv[$key]);
            }

            if (str_starts_with($arg, '--include-posts=')) {
                $options['include-posts'] = (int)substr($arg, 17);
                unset($argv[$key]);
            }
        }

        // remaining argument = feed ID
        $feedId = (int)array_values($argv)[0];

        $service = new FeedCopyService();
        $newId = $service->copyFeed(
            $feedId,
            $options['only'],
            $options['include-posts']
        );

        echo "Copied feed to ID: {$newId}\n";
    }
}

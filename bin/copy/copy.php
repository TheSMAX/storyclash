<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Command\CopyFeedCommand;

// If no arguments provided, show help
if ($argc < 2 || in_array($argv[1], ['-h', '--help'])) {
    echo <<<HELP
Usage:
  copy <feedId>
  copy --only=instagram <feedId>
  copy --only=tiktok <feedId>
  copy --only=instagram --include-posts=5 <feedId>

Options:
  --only=instagram|tiktok   Copy only the given source table
  --include-posts=<num>     Also copy <num> posts
  -h, --help                Show this help message

Example:
  ./bin/copy 123
  ./bin/copy --only=instagram 123
  ./bin/copy --only=instagram --include-posts=5 123

HELP;
    exit(0);
}

try {
    $command = new CopyFeedCommand();
    $command->run($argv);
    exit(0);

} catch (Exception $e) {
    fwrite(STDERR, "Error: " . $e->getMessage() . "\n");
    exit(1);
}
<?php

use App\Command\CopyFeedCommand;
use PHPUnit\Framework\TestCase;

class CopyFeedCommandTest extends TestCase
{
    public function testCommandParsesArguments()
    {
        $cmd = new CopyFeedCommand();

        $reflection = new ReflectionClass($cmd);
        $method = $reflection->getMethod('run');
        $method->setAccessible(true);

        // We mock the service call by intercepting echo output
        $this->expectOutputRegex('/Copied feed to ID:/');

        $cmd->run([
            'copy',
            '--only=instagram',
            '--include-posts=3',
            '55'
        ]);
    }
}

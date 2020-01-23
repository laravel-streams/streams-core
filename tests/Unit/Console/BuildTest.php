<?php

class BuildTest extends TestCase
{

    public function testConsoleCommand()
    {
        $this->artisan('build')->assertExitCode(0);
    }
}

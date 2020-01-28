<?php

use Tests\TestCase;

class BuildTest extends TestCase
{

    public function testConsoleCommand()
    {
        $this->artisan('build')->assertExitCode(0);
    }
}

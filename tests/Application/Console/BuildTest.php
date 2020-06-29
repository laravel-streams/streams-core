<?php

use Tests\TestCase;

class BuildTest extends TestCase
{
    /**
     * @todo StreamModel failure
     */
    public function testConsoleCommand()
    {
        $this->markTestSkipped();
        $this->artisan('build')->assertExitCode(0);
    }
}

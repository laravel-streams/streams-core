<?php

class RefreshTest extends TestCase
{

    public function testConsoleCommand()
    {
        $this->artisan('refresh')->assertExitCode(0);
    }
}

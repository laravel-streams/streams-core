<?php

use Tests\TestCase;

class EnvSetTest extends TestCase
{

    public function testConsoleCommand()
    {
        $time = time();

        $this->artisan('env:set DUMMY_TEST=' . $time)->assertExitCode(0);

        $this->assertEquals(true, str_contains(file_get_contents(base_path('.env')), 'DUMMY_TEST=' . $time));
    }

    public function testCanQuoteValuesWithSpaces()
    {
        $value = 'Test Value';

        $this->artisan('env:set DUMMY_TEST="' . $value . '"')->assertExitCode(0);

        $this->assertEquals(true, str_contains(file_get_contents(base_path('.env')), 'DUMMY_TEST="' . $value . '"'));
    }
}

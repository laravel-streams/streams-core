<?php

class RefreshTest extends TestCase
{

    public function testConsoleCommand()
    {
        file_put_contents(base_path('bootstrap/cache/config.php'), '');
        file_put_contents(base_path('bootstrap/cache/routes.php'), '');

        $this->artisan('refresh')->assertExitCode(0);

        unlink(base_path('bootstrap/cache/config.php'));
        unlink(base_path('bootstrap/cache/routes.php'));
    }
}

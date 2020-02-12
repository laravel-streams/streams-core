<?php

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Addon\Event\AddonWasUninstalled;
use Tests\TestCase;

class AddonWasUninstalledTest extends TestCase
{

    public function testGetAddon()
    {
        $this->assertTrue((new AddonWasUninstalled(app('anomaly.module.users')))->getAddon() instanceof Addon);
    }
}

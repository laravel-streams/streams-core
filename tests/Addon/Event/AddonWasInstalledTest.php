<?php

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Addon\Event\AddonWasInstalled;
use Tests\TestCase;

class AddonWasInstalledTest extends TestCase
{

    public function testGetAddon()
    {
        $this->assertTrue((new AddonWasInstalled(app('anomaly.module.users')))->getAddon() instanceof Addon);
    }
}

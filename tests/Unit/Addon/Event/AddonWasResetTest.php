<?php

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Addon\Event\AddonWasReset;
use Tests\TestCase;

class AddonWasResetTest extends TestCase
{

    public function testGetAddon()
    {
        $this->assertTrue((new AddonWasReset(app('anomaly.module.users')))->getAddon() instanceof Addon);
    }
}

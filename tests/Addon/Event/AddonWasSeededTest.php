<?php

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Addon\Event\AddonWasSeeded;
use Tests\TestCase;

class AddonWasSeededTest extends TestCase
{

    public function testGetAddon()
    {
        $this->assertTrue((new AddonWasSeeded(app('anomaly.module.users')))->getAddon() instanceof Addon);
    }
}

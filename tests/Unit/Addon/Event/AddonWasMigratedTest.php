<?php

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Addon\Event\AddonWasMigrated;
use Tests\TestCase;

class AddonWasMigratedTest extends TestCase
{

    public function testGetAddon()
    {
        $this->assertTrue((new AddonWasMigrated(app('anomaly.module.users')))->getAddon() instanceof Addon);
    }
}

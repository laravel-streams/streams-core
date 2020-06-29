<?php

use Tests\TestCase;
use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Addon\AddonManager;
use Anomaly\Streams\Platform\Addon\AddonCollection;

class AddonManagerTest extends TestCase
{

    public function testInstall()
    {
        $manager = app(AddonManager::class);
        $addons = app(AddonCollection::class);

        $this->assertTrue($manager->install($addons->instance('anomaly.module.users'), true));
        $this->assertTrue($manager->install($addons->instance('anomaly.field_type.text'), true));
    }

    public function testUninstall()
    {
        $manager = app(AddonManager::class);
        $addons = app(AddonCollection::class);

        $this->assertTrue($manager->uninstall($addons->instance('anomaly.field_type.text')));
    }

    public function testEnable()
    {
        $manager = app(AddonManager::class);
        $addons = app(AddonCollection::class);

        $this->assertTrue($manager->enable($addons->instance('anomaly.field_type.text')));
    }

    public function testDisable()
    {
        $manager = app(AddonManager::class);
        $addons = app(AddonCollection::class);

        $this->assertTrue($manager->disable($addons->instance('anomaly.field_type.text')));
    }
}

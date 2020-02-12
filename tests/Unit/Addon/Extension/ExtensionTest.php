<?php

use Tests\TestCase;
use Anomaly\Streams\Platform\Addon\AddonCollection;

class ExtensionTest extends TestCase
{

    public function testGetProvides()
    {
        $addons = app(AddonCollection::class);

        $this->assertTrue($addons->instance('anomaly.extension.default_authenticator')->getProvides() === 'anomaly.module.users::authenticator.default');
    }

    public function testToArray()
    {
        $addons = app(AddonCollection::class);

        $addon = $addons->instance('anomaly.extension.default_authenticator');

        $this->assertTrue($addon->toArray() == [
            'name'      => $addon->getName(),
            'type'      => $addon->getType(),
            'path'      => $addon->getPath(),
            'slug'      => $addon->getSlug(),
            'vendor'    => $addon->getVendor(),
            'namespace' => $addon->getNamespace(),

            'enabled'   => $addon->isEnabled(),
            'installed' => $addon->isInstalled(),
        ]);
    }
}

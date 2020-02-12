<?php

use Tests\TestCase;
use Anomaly\Streams\Platform\Addon\AddonCollection;

class ModuleTest extends TestCase
{

    public function testProvides()
    {
        $addons = app(AddonCollection::class);

        $this->assertTrue($addons->instance('anomaly.extension.default_authenticator')->provides() === 'anomaly.module.users::authenticator.default');
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

            'provides'  => $addon->provides(),
            'enabled'   => $addon->isEnabled(),
            'installed' => $addon->isInstalled(),
        ]);
    }
}

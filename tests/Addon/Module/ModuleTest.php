<?php

use Tests\TestCase;
use Illuminate\Testing\Assert;
use Anomaly\Streams\Platform\Addon\AddonCollection;

class ModuleTest extends TestCase
{

    /**
     * We're better off using direct assertions, as we get more robust failure messages in the test runner, rather than the bare "failed asserting false equals true".
     */
    public function testProvides()
    {
        $addons = app(AddonCollection::class);

        $this->assertEquals('anomaly.module.users::authenticator.default', $addons->instance('anomaly.extension.default_authenticator')->provides());
    }

    /**
     * Note that PHPUnit (stupidly) deprecated assertArraySubset in PHPUnit 8. Alternatives include an assertEquals loop or using Laravel's extrapolation (currently done).
     */
    public function testToArray()
    {
        return $this->markTestSkipped();

        $addons = app(AddonCollection::class);

        $addon = $addons->instance('anomaly.extension.default_authenticator');

        Assert::assertArraySubset([
            'name'      => $addon->getName(),
            'type'      => $addon->getType(),
            'path'      => $addon->getPath(),
            'slug'      => $addon->getSlug(),
            'vendor'    => $addon->getVendor(),
            'namespace' => $addon->getNamespace(),

            'provides'  => $addon->provides(),
            'enabled'   => $addon->isEnabled(),
            'installed' => $addon->isInstalled(),
        ], $addon->toArray());
    }
}

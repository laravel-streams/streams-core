<?php

use Tests\TestCase;
use Illuminate\Testing\Assert;
use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Addon\AddonServiceProvider;

class AddonTest extends TestCase
{

    public function testIsInstalled()
    {
        $addons = app(AddonCollection::class);

        $this->assertIsBool($addons->instance('anomaly.module.users')->isInstalled());
    }

    public function testIsEnabled()
    {
        $addons = app(AddonCollection::class);

        $this->assertIsBool($addons->instance('anomaly.module.users')->isEnabled());
    }

    public function testIsCore()
    {
        $addons = app(AddonCollection::class);

        $this->assertIsBool($addons->instance('anomaly.module.users')->isCore());
    }

    public function testIsShared()
    {
        $addons = app(AddonCollection::class);

        $this->assertIsBool($addons->instance('anomaly.module.users')->isShared());
    }

    public function testIsTesting()
    {
        $addons = app(AddonCollection::class);

        $this->assertIsBool($addons->instance('anomaly.module.users')->isTesting());
    }

    public function testGetName()
    {
        $addons = app(AddonCollection::class);

        $this->assertTrue($addons->instance('anomaly.module.users')->getName() === 'anomaly.module.users::addon.name');
    }

    public function testGetDescription()
    {
        $addons = app(AddonCollection::class);

        $this->assertTrue($addons->instance('anomaly.module.users')->getDescription() === 'anomaly.module.users::addon.description');
    }

    public function testGetNamespace()
    {
        $addons = app(AddonCollection::class);

        $this->assertTrue($addons->instance('anomaly.module.users')->getNamespace('test') === 'anomaly.module.users::test');
    }

    public function testHasConfig()
    {
        $addons = app(AddonCollection::class);

        $this->assertIsBool($addons->instance('anomaly.module.users')->hasConfig('test'));
    }

    public function testHasAnyConfig()
    {
        $addons = app(AddonCollection::class);

        $this->assertIsBool($addons->instance('anomaly.module.users')->hasAnyConfig(['test']));
    }

    public function testGetComposerJson()
    {
        $addons = app(AddonCollection::class);

        $this->assertTrue($addons->instance('anomaly.module.users')->getComposerJson()['name'] === 'anomaly/users-module');
    }

    public function testGetComposerLock()
    {
        $addons = app(AddonCollection::class);

        $this->assertTrue(isset($addons->instance('anomaly.module.users')->getComposerLock()['version']));
    }

    public function testGetReadMe()
    {
        $addons = app(AddonCollection::class);

        $this->assertTrue(str_contains($addons->instance('anomaly.module.users')->getReadMe(), 'Users Module'));
    }

    public function testGetPackageName()
    {
        $addons = app(AddonCollection::class);

        $this->assertTrue($addons->instance('anomaly.module.users')->getPackageName() === 'anomaly/users-module');
    }

    public function testPath()
    {
        $addons = app(AddonCollection::class);

        $this->assertTrue($addons->instance('anomaly.module.users')->path('resources') === base_path('vendor/anomaly/users-module/resources'));
    }

    public function testGetAppPath()
    {
        $addons = app(AddonCollection::class);

        $this->assertTrue($addons->instance('anomaly.module.users')->getAppPath('resources') === 'vendor/anomaly/users-module/resources');
    }

    public function testGetAddons()
    {
        $addons = app(AddonCollection::class);

        $this->assertIsArray($addons->instance('anomaly.module.users')->getAddons());
    }

    /**
     * @todo what is the purpose of this test? Is it asserting the attributes returned in the built addon?
     */
    public function testToArray()
    {
        return $this->markTestSkipped();

        $addons = app(AddonCollection::class);

        $addon = $addons->instance('anomaly.module.users');

        Assert::assertArraySubset([
            'name'      => $addon->name,
            'type'      => $addon->type,
            'path'      => $addon->path,
            'slug'      => $addon->slug,
            'vendor'    => $addon->vendor,
            'namespace' => $addon->namespace,

            'enabled'   => $addon->enabled,
            'installed' => $addon->installed,
        ], $addon->toArray());
    }
}

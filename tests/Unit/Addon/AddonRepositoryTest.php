<?php

use Tests\TestCase;
use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Addon\Contract\AddonRepositoryInterface;
use Anomaly\Streams\Platform\Model\EloquentQueryBuilder;

class AddonRepositoryTest extends TestCase
{

    public function testUninstall()
    {
        $addons     = app(AddonCollection::class);
        $repository = app(AddonRepositoryInterface::class);

        if ($addon = $repository->findBy('namespace', 'anomaly.module.users')) {

            $repository->delete($addon);

            EloquentQueryBuilder::resetMemory();
        }

        $this->assertTrue($repository->uninstall($addons->instance('anomaly.field_type.text')));
        $this->assertTrue($repository->uninstall($addons->instance('anomaly.module.users')));
    }

    public function testInstall()
    {
        $addons     = app(AddonCollection::class);
        $repository = app(AddonRepositoryInterface::class);

        if ($addon = $repository->findBy('namespace', 'anomaly.module.users')) {

            $repository->delete($addon);

            EloquentQueryBuilder::resetMemory();
        }

        $this->assertTrue($repository->install($addons->instance('anomaly.module.users'), true));
    }

    public function testDisable()
    {
        $addons     = app(AddonCollection::class);
        $repository = app(AddonRepositoryInterface::class);

        EloquentQueryBuilder::resetMemory();

        $this->assertTrue($repository->disable($addons->instance('anomaly.module.users')));
        $this->assertTrue($repository->disable($addons->instance('anomaly.field_type.text')));
    }

    public function testEnable()
    {
        $addons     = app(AddonCollection::class);
        $repository = app(AddonRepositoryInterface::class);

        EloquentQueryBuilder::resetMemory();

        $this->assertTrue($repository->enable($addons->instance('anomaly.module.users')));
        $this->assertTrue($repository->enable($addons->instance('anomaly.field_type.text')));
    }
}

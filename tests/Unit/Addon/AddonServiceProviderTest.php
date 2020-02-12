<?php

use Tests\TestCase;
use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Addon\Contract\AddonRepositoryInterface;
use Anomaly\Streams\Platform\Model\EloquentQueryBuilder;

// @todo revisit after creating test-module
class AddonServiceProviderTest extends TestCase
{

    public function testCanRegister()
    {
        $addons = app(AddonCollection::class);
        $repository = app(AddonRepositoryInterface::class);

        $repository->uninstall($addons->instance('anomaly.module.users'));

        EloquentQueryBuilder::resetMemory();

        $this->assertTrue($addons->instance('anomaly.module.users') instanceof Addon);
        $this->assertTrue($addons->instance('anomaly.field_type.text') instanceof Addon);
    }
}

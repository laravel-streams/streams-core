<?php

namespace Anomaly\TestModule;

use Illuminate\Contracts\Support\DeferrableProvider;
use Anomaly\Streams\Platform\Addon\AddonServiceProvider;

class TestModuleServiceProvider extends AddonServiceProvider implements DeferrableProvider
{

    /**
     * Return the provided services.
     */
    public function provides()
    {
        return [TestModule::class, 'anomaly.module.test'];
    }
}

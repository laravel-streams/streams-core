<?php namespace Anomaly\Streams\Platform\Addon\Distribution;

use Anomaly\Streams\Platform\Addon\AddonServiceProvider;

class DistributionServiceProvider extends AddonServiceProvider
{

    protected function onAfterRegister()
    {
        $this->app->singleton(
            'streams.distribution',
            function () {

                return app('streams.distributions')->first();
            }
        );
    }
}

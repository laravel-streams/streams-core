<?php namespace Streams\Platform\Addon\Distribution;

use Streams\Platform\Addon\AddonServiceProvider;

class DistributionServiceProvider extends AddonServiceProvider
{
    protected $type = 'distribution';

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

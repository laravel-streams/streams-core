<?php namespace Streams\Platform\Addon\Distribution;

use Streams\Platform\Addon\AddonServiceProvider;

class DistributionServiceProvider extends AddonServiceProvider
{
    protected function onAfterRegister()
    {
        $this->app->singleton(
            'streams.distribution',
            function () {

                return app('streams.distributions')->findBySlug('base');

            }
        );
    }
}

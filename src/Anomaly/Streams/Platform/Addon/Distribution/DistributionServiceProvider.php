<?php namespace Anomaly\Streams\Platform\Addon\Distribution;

use Anomaly\Streams\Platform\Addon\AddonServiceProvider;
use Illuminate\Foundation\Application;

/**
 * Class DistributionServiceProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Distribution
 */
class DistributionServiceProvider extends AddonServiceProvider
{
    public function __construct(Application $app)
    {
        parent::__construct($app);

        $this->app['events']->listen(
            'streams.boot',
            '\Anomaly\Streams\Platform\Addon\Distribution\DistributionListener@whenStreamsIsBooting'
        );

        $this->app['events']->listen(
            'Anomaly.Streams.Platform.Addon.*',
            '\Anomaly\Streams\Platform\Addon\Distribution\DistributionListener'
        );
    }
}

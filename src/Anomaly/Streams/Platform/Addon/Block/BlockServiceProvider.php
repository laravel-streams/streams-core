<?php namespace Anomaly\Streams\Platform\Addon\Block;

use Anomaly\Streams\Platform\Addon\AddonServiceProvider;
use Illuminate\Foundation\Application;

/**
 * Class BlockServiceProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Block
 */
class BlockServiceProvider extends AddonServiceProvider
{
    public function __construct(Application $app)
    {
        parent::__construct($app);

        $this->app['events']->listen(
            'Anomaly.Streams.Platform.Addon.*',
            '\Anomaly\Streams\Platform\Addon\Block\BlockListener'
        );
    }
}

<?php namespace Anomaly\Streams\Platform\Addon\FieldType;

use Anomaly\Streams\Platform\Addon\AddonServiceProvider;
use Illuminate\Foundation\Application;

/**
 * Class FieldTypeServiceProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\FieldType
 */
class FieldTypeServiceProvider extends AddonServiceProvider
{
    /**
     * The binding type.
     *
     * @var string
     */
    protected $binding = 'bind';

    public function __construct(Application $app)
    {
        parent::__construct($app);

        $this->app['events']->listen(
            'Anomaly.Streams.Platform.Addon.*',
            '\Anomaly\Streams\Platform\Addon\FieldType\FieldTypeListener'
        );
    }
}

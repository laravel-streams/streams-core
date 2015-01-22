<?php namespace Anomaly\Streams\Platform\Addon\Theme;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;

/**
 * Class ThemeEventProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Theme
 */
class ThemeEventProvider extends EventServiceProvider
{

    /**
     * Event listeners.
     *
     * @var array
     */
    protected $listen = [
        'Anomaly\Streams\Platform\Addon\Theme\Event\ThemeWasRegistered' => [
            'Anomaly\Streams\Platform\Addon\Theme\Listener\PutThemeInCollection'
        ]
    ];

}

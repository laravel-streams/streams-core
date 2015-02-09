<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;

/**
 * Class FilterEventProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Filter
 */
class FilterEventProvider extends EventServiceProvider
{

    /**
     * Event listeners.
     *
     * @var array
     */
    protected $listen = [
        'Anomaly\Streams\Platform\Ui\Table\Event\QueryHasStarted' => [
            'Anomaly\Streams\Platform\Ui\Table\Component\Filter\Listener\FilterResults'
        ]
    ];

}

<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Column;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;

/**
 * Class ColumnEventProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Column
 */
class ColumnEventProvider extends EventServiceProvider
{

    /**
     * Event listeners.
     *
     * @var array
     */
    protected $listen = [
        'Anomaly\Streams\Platform\Ui\Table\Event\QueryHasStarted' => [
            'Anomaly\Streams\Platform\Ui\Table\Component\Column\Listener\OrderResults'
        ]
    ];

}

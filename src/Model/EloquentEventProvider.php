<?php namespace Anomaly\Streams\Platform\Model;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;

/**
 * Class EloquentEventProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Model
 */
class EloquentEventProvider extends EventServiceProvider
{

    /**
     * Event listeners.
     *
     * @var array
     */
    protected $listen = [
        'Anomaly\Streams\Platform\Model\Event\ModelWasCreated'   => [
            'Anomaly\Streams\Platform\Model\Listener\FlushCache'
        ],
        'Anomaly\Streams\Platform\Model\Event\ModelWasSaved'     => [
            'Anomaly\Streams\Platform\Model\Listener\FlushCache'
        ],
        'Anomaly\Streams\Platform\Model\Event\ModelWasUpdated'   => [
            'Anomaly\Streams\Platform\Model\Listener\FlushCache'
        ],
        'Anomaly\Streams\Platform\Model\Event\ModelsWereUpdated' => [
            'Anomaly\Streams\Platform\Model\Listener\FlushCache'
        ],
        'Anomaly\Streams\Platform\Model\Event\ModelsWereDeleted' => [
            'Anomaly\Streams\Platform\Model\Listener\FlushCache'
        ],
        'Anomaly\Streams\Platform\Model\Event\ModelWasDeleted'   => [
            'Anomaly\Streams\Platform\Model\Listener\DeleteTranslations'
        ],
        'Anomaly\Streams\Platform\Model\Event\ModelWasRestored'  => [
            'Anomaly\Streams\Platform\Model\Listener\FlushCache'
        ]
    ];

}

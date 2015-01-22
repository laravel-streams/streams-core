<?php namespace Anomaly\Streams\Platform\Addon\FieldType;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;

/**
 * Class FieldTypeEventProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\FieldType
 */
class FieldTypeEventProvider extends EventServiceProvider
{

    /**
     * Event listeners.
     *
     * @var array
     */
    protected $listen = [
        'Anomaly\Streams\Platform\Addon\FieldType\Event\FieldTypeWasRegistered' => [
            'Anomaly\Streams\Platform\Addon\FieldType\Listener\PutFieldTypeInCollection'
        ]
    ];

}

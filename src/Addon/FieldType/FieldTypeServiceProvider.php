<?php namespace Anomaly\Streams\Platform\Addon\FieldType;

use Anomaly\Streams\Platform\Addon\FieldType\Command\RegisterFieldTypes;
use Anomaly\Streams\Platform\Addon\FieldType\Command\RegisterListeners;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Support\ServiceProvider;

/**
 * Class FieldTypeServiceProvider
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\FieldType
 */
class FieldTypeServiceProvider extends ServiceProvider
{

    use DispatchesCommands;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            'Anomaly\Streams\Platform\Addon\FieldType\FieldTypeCollection',
            'Anomaly\Streams\Platform\Addon\FieldType\FieldTypeCollection'
        );

        $this->app->bind(
            'field_type.collection',
            'Anomaly\Streams\Platform\Addon\FieldType\FieldTypeCollection'
        );

        $this->app->register('Anomaly\Streams\Platform\Addon\FieldType\FieldTypeEventProvider');
    }
}

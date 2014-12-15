<?php namespace Anomaly\Streams\Platform\Addon\FieldType;

use Anomaly\Streams\Platform\Addon\FieldType\Event\FieldTypesHaveRegistered;
use Illuminate\Support\ServiceProvider;
use Laracasts\Commander\Events\DispatchableTrait;
use Laracasts\Commander\Events\EventGenerator;

/**
 * Class FieldTypeServiceProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\FieldType
 */
class FieldTypeServiceProvider extends ServiceProvider
{

    use EventGenerator;
    use DispatchableTrait;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerListeners();
        $this->registerCollection();

        $this->registerFieldTypes();

        $this->raise(new FieldTypesHaveRegistered());

        $this->dispatchEventsFor($this);
    }

    /**
     * Register the field type listener.
     */
    protected function registerListeners()
    {
        $this->app->make('events')->listen(
            'Anomaly.Streams.Platform.Addon.*',
            'Anomaly\Streams\Platform\Addon\FieldType\FieldTypeListener'
        );
    }

    /**
     * Register the field type collection.
     */
    protected function registerCollection()
    {
        $this->app->instance('streams.field_types', new FieldTypeCollection());
    }

    /**
     * Register all the field type addons.
     */
    protected function registerFieldTypes()
    {
        $this->app->make('streams.addon.manager')->register('field_type');
    }
}

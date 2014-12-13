<?php namespace Anomaly\Streams\Platform\Addon\FieldType;

use Anomaly\Streams\Platform\Addon\Extension\Event\ExtensionsHaveRegistered;
use Anomaly\Streams\Platform\Addon\FieldType\Event\FieldTypesHaveRegistered;
use Illuminate\Support\ServiceProvider;
use Laracasts\Commander\Events\DispatchableTrait;
use Laracasts\Commander\Events\EventGenerator;

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

    protected function registerListeners()
    {
        $this->app->make('events')->listen(
            'Anomaly.Streams.Platform.Addon.*',
            '\Anomaly\Streams\Platform\Addon\FieldType\FieldTypeListener'
        );
    }

    protected function registerCollection()
    {
        $this->app->instance('streams.field_types', new FieldTypeCollection());
    }

    protected function registerFieldTypes()
    {
        $this->app->make('streams.addon.manager')->register('field_type');
    }
}

<?php namespace Anomaly\Streams\Platform\Addon\Extension;

use Anomaly\Streams\Platform\Addon\Extension\Event\ExtensionsHaveRegistered;
use Illuminate\Support\ServiceProvider;
use Laracasts\Commander\Events\DispatchableTrait;
use Laracasts\Commander\Events\EventGenerator;

class ExtensionServiceProvider extends ServiceProvider
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

        $this->registerExtensions();

        $this->raise(new ExtensionsHaveRegistered());

        $this->dispatchEventsFor($this);
    }

    protected function registerListeners()
    {
        $this->app->make('events')->listen(
            'Anomaly.Streams.Platform.Addon.*',
            '\Anomaly\Streams\Platform\Addon\Extension\ExtensionListener'
        );
    }

    protected function registerCollection()
    {
        $this->app->instance('streams.extensions', new ExtensionCollection());
    }

    protected function registerExtensions()
    {
        $this->app->make('streams.addon.manager')->register('extension');
    }
}

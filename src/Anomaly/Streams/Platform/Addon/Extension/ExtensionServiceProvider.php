<?php namespace Anomaly\Streams\Platform\Addon\Extension;

use Anomaly\Streams\Platform\Addon\Extension\Event\ExtensionsHaveRegistered;
use Illuminate\Support\ServiceProvider;
use Laracasts\Commander\Events\DispatchableTrait;
use Laracasts\Commander\Events\EventGenerator;

/**
 * Class ExtensionServiceProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Extension
 */
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

    /**
     * Register the extension listener.
     */
    protected function registerListeners()
    {
        $this->app->make('events')->listen(
            'Anomaly.Streams.Platform.Addon.*',
            '\Anomaly\Streams\Platform\Addon\Extension\ExtensionListener'
        );
    }

    /**
     * Register the extension collection.
     */
    protected function registerCollection()
    {
        $this->app->instance('streams.extensions', new ExtensionCollection());
    }

    /**
     * Register all extension addons.
     */
    protected function registerExtensions()
    {
        $this->app->make('streams.addon.manager')->register('extension');
    }
}

<?php namespace Anomaly\Streams\Platform\Provider;

use Illuminate\Support\ServiceProvider;

class ListenerServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerAddonListeners();
    }

    /**
     * Register addon.* listeners.
     */
    protected function registerAddonListeners()
    {
        app('events')->listen('Streams.Platform.Addon.Module.Event.*', 'Anomaly\Streams\Platform\Addon\Module\ModuleListener');
    }
}

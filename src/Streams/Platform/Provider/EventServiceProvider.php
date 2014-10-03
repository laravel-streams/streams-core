<?php namespace Streams\Platform\Provider;

use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerFieldEvents();
    }

    protected function registerFieldEvents()
    {
        $events = app('events');
    }
}

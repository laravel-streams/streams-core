<?php namespace Streams\Platform\Provider;

use Streams\Platform\Support\Messages;
use Illuminate\Support\ServiceProvider;

class MessagesServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->instance('messages', new Messages($this->app->make('session.store')));
    }
}

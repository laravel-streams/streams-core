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
        $this->app->instance('streams.messages', new Messages(app('session.store')));
    }
}

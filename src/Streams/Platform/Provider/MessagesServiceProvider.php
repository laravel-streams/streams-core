<?php namespace Streams\Platform\Provider;

use Streams\Platform\Support\Messages;
use Illuminate\Support\ServiceProvider;

class MessagesServiceProvider extends ServiceProvider
{
    /**
     * Register our message bag.
     */
    public function register()
    {
        $this->app->instance('streams.messages', new Messages(app('session.store')));
    }
}

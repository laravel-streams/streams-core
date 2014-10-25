<?php namespace Anomaly\Streams\Platform\Provider;

use Illuminate\Support\ServiceProvider;
use Anomaly\Streams\Platform\Support\Messages;

class MessagesServiceProvider extends ServiceProvider
{

    /**
     * Register our message bag.
     */
    public function register()
    {
        $this->app->instance('streams.messages', new Messages());
    }

}

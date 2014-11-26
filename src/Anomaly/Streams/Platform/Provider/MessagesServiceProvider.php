<?php namespace Anomaly\Streams\Platform\Provider;

use Anomaly\Streams\Platform\Support\Messages;

class MessagesServiceProvider extends \Illuminate\Support\ServiceProvider
{

    /**
     * Register our message bag.
     */
    public function register()
    {
        $this->app->instance('streams.messages', new Messages());
    }
}

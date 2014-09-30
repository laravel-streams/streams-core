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
        $this->registerMessagesClass();
    }

    /**
     * Register the messages class for Streams.
     */
    protected function registerMessagesClass()
    {
        $this->app->singleton(
            'messages',
            function () {
                return new Messages(app()->make('session.store'));
            }
        );
    }
}

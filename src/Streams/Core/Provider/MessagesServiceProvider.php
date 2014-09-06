<?php namespace Streams\Core\Provider;

use Illuminate\Support\ServiceProvider;
use Streams\Core\Support\Messages;

class MessagesServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton(
            'messages',
            function () {
                return new Messages(\App::make('session.store'));
            }
        );
    }
}

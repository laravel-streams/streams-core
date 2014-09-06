<?php namespace Streams\Core\Provider;

use McCool\LaravelAutoPresenter\LaravelAutoPresenterServiceProvider;

class PresenterServiceProvider extends LaravelAutoPresenterServiceProvider
{
    /**
     * Register the service provider.
     * In this case we're overriding the package one.
     */
    public function register()
    {
    	$this->app->singleton('McCool\LaravelAutoPresenter\PresenterDecorator', 'Streams\Core\Support\Decorator');
    }
}

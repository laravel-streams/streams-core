<?php namespace Streams\Platform\Provider;

use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->setViewPath();
        $this->addStreamsNamespaceHint();
    }

    /**
     * Set the default view path inside to the
     * Streams Platform's resources views.
     */
    protected function setViewPath()
    {
        app()->make('config')->set('view.paths', [__DIR__ . '/../../../../resources/views']);
    }

    /**
     * Add the "streams" namespace hint to views.
     */
    protected function addStreamsNamespaceHint()
    {
        app()->make('view')->addNamespace('streams', __DIR__ . '/../../../../resources/views');
    }
}

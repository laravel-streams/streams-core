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
        $this->registerOurViewComposer();
    }

    /**
     * Set the default view path inside to the
     * Streams Platform's resources views.
     */
    protected function setViewPath()
    {
        $this->app->make('config')->set('view.paths', [__DIR__ . '/../../../../resources/views']);
    }

    /**
     * Add the "streams" namespace hint to views.
     */
    protected function addStreamsNamespaceHint()
    {
        $this->app->make('view')->addNamespace('streams', __DIR__ . '/../../../../resources/views');
    }

    /**
     * Use our own view composer.
     */
    protected function registerOurViewComposer()
    {
        $this->app->make('view')->composer('*', 'Streams\Platform\Support\Composer');
    }
}

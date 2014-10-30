<?php namespace Anomaly\Streams\Platform\Provider;

use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{

    /**
     * Setup view rendering services.
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
        app('config')->set('view.paths', [__DIR__ . '/../../../../../resources/views']);
    }

    /**
     * Add the "streams" namespace hint to views.
     */
    protected function addStreamsNamespaceHint()
    {
        app('view')->addNamespace('streams', __DIR__ . '/../../../../../resources/views');
    }

    /**
     * Use our own view composer.
     */
    protected function registerOurViewComposer()
    {
        app('view')->composer('*', 'Anomaly\Streams\Platform\Support\Composer');
    }
}

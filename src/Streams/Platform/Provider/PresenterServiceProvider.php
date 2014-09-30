<?php namespace Streams\Platform\Provider;

use Illuminate\Support\ServiceProvider;

class PresenterServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        //
    }

    /**
     * Auto decorate items.
     */
    public function boot()
    {
        $this->registerContentRenderingTrigger();
        $this->registerContentRenderingListener();
    }

    /**
     * Register our hook for composing views.
     */
    protected function registerContentRenderingTrigger()
    {
        app()->make('view')->composer(
            '*',
            function ($view) {
                if ($view instanceOf \Illuminate\View\View) {
                    app()->make('events')->fire('content.rendering', array($view));
                }
            }
        );
    }

    /**
     * Register the event listener we are firing
     * in the hook registered above.
     */
    protected function registerContentRenderingListener()
    {
        app()->make('events')->listen(
            'content.rendering',
            function ($view) {
                if ($viewData = array_merge($view->getFactory()->getShared(), $view->getData())) {
                    foreach ($viewData as $key => $value) {
                        $view[$key] = app()->make('streams.decorator')->decorate($value);
                    }
                } else {
                    return;
                }
            }
        );
    }
}

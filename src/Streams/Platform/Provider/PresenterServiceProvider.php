<?php namespace Streams\Platform\Provider;

use Illuminate\Support\ServiceProvider;

class PresenterServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
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
        app('view')->composer(
            '*',
            function ($view) {
                if ($view instanceOf \Illuminate\View\View) {
                    app('events')->fire('content.rendering', array($view));
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
        app('events')->listen(
            'content.rendering',
            function ($view) {
                $data = array_merge($view->getFactory()->getShared(), $view->getData());

                if (!$data) {
                    return;
                }

                foreach ($data as $key => $value) {
                    $view[$key] = app('streams.decorator')->decorate($value);
                }
            }
        );
    }
}

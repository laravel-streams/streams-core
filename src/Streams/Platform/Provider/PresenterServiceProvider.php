<?php namespace Streams\Platform\Provider;

use Illuminate\Support\ServiceProvider;

class PresenterServiceProvider extends ServiceProvider
{
    /**
     * We register this in our StreamsServiceProvider.
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
        // Fire when view is loaded.
        \View::composer(
            '*',
            function ($view) {
                if ($view instanceOf \Illuminate\View\View) {
                    \Event::fire('content.rendering', array($view));
                }
            }
        );

        $app = $this->app;

        \Event::listen(
            'content.rendering',
            function ($view) use ($app) {
                $sharedData = $view->getFactory()->getShared();
                $viewData   = array_merge($sharedData, $view->getData());

                if (!$viewData) {
                    return;
                }

                foreach ($viewData as $key => $value) {
                    $view[$key] = \Decorator::decorate($value);
                }
            }
        );
    }
}

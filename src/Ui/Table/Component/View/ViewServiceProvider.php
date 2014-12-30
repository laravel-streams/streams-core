<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\View;

use Illuminate\Support\ServiceProvider;

/**
 * Class ViewServiceProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\View
 */
class ViewServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
        $this->registerListeners();
    }

    /**
     * Register bindings.
     */
    protected function registerBindings()
    {
        $this->app->instance(
            'streams::table.view.factory',
            'Anomaly\Streams\Platform\Ui\Table\Component\View\ViewFactory'
        );

        $this->app->singleton(
            'Anomaly\Streams\Platform\Ui\Table\Component\View\ViewRegistry',
            'Anomaly\Streams\Platform\Ui\Table\Component\View\ViewRegistry'
        );
    }

    /**
     * Register listeners.
     */
    protected function registerListeners()
    {
        $this->app->make('events')->listen(
            'streams::table.query',
            'Anomaly\Streams\Platform\Ui\Table\Component\View\Listener\TableQueryListener'
        );
    }
}

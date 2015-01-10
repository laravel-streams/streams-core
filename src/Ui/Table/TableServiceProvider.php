<?php namespace Anomaly\Streams\Platform\Ui\Table;

use Illuminate\Support\ServiceProvider;

/**
 * Class TableServiceProvider
 *
 * @property mixed registerListeners
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table
 */
class TableServiceProvider extends ServiceProvider
{

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->app->make('twig')->addExtension(app('Anomaly\Streams\Platform\Ui\Table\TablePlugin'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerComponents();
        $this->registerListeners();
    }

    /**
     * Register table components.
     */
    protected function registerComponents()
    {
        $this->app->register('Anomaly\Streams\Platform\Ui\Table\Component\View\ViewServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Ui\Table\Component\Action\ActionServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Ui\Table\Component\Filter\FilterServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Ui\Table\Component\Column\ColumnServiceProvider');
    }

    /**
     * Register listeners.
     */
    protected function registerListeners()
    {
        $this->app->make('events')->listen(
            'Anomaly\Streams\Platform\Ui\Table\Event\TableQueryEvent',
            'Anomaly\Streams\Platform\Ui\Table\Listener\TableQueryListener'
        );
    }
}

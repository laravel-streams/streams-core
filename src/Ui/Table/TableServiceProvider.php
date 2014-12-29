<?php namespace Anomaly\Streams\Platform\Ui\Table;

use Illuminate\Support\ServiceProvider;

/**
 * Class TableServiceProvider
 *
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
        app('twig')->addExtension(app('Anomaly\Streams\Platform\Ui\Table\TablePlugin'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerComponents();
        $this->registerSubscribers();
    }

    /**
     * Register components.
     */
    protected function registerComponents()
    {
        $this->app->register('Anomaly\Streams\Platform\Ui\Table\Component\View\ViewServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Ui\Table\Component\Filter\FilterServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Ui\Table\Component\Column\ColumnServiceProvider');
    }

    /**
     * Register event subscribers.
     */
    protected function registerSubscribers()
    {
        $this->app->make('events')->subscribe(
            'Anomaly\Streams\Platform\Ui\Table\Subscriber\TableMakeSubscriber'
        );

        $this->app->make('events')->subscribe(
            'Anomaly\Streams\Platform\Ui\Table\Subscriber\TablePostSubscriber'
        );

        $this->app->make('events')->subscribe(
            'Anomaly\Streams\Platform\Ui\Table\Subscriber\TableBuildSubscriber'
        );

        $this->app->make('events')->subscribe(
            'Anomaly\Streams\Platform\Ui\Table\Subscriber\TableReadySubscriber'
        );

        $this->app->make('events')->subscribe(
            'Anomaly\Streams\Platform\Ui\Table\Subscriber\TableQuerySubscriber'
        );
    }
}

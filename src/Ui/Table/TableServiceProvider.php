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
        $this->app->bind(
            'Anomaly\Streams\Platform\Ui\Table\View\Contract\ViewRepositoryInterface',
            'Anomaly\Streams\Platform\Ui\Table\View\ViewRepository'
        );

        $this->app->bind(
            'Anomaly\Streams\Platform\Ui\Table\Filter\Contract\FilterRepositoryInterface',
            'Anomaly\Streams\Platform\Ui\Table\Filter\FilterRepository'
        );

        $this->app->bind(
            'Anomaly\Streams\Platform\Ui\Table\Action\Contract\ActionRepositoryInterface',
            'Anomaly\Streams\Platform\Ui\Table\Action\ActionRepository'
        );
    }

    /**
     * Register the table listener.
     */
    protected function registerListeners()
    {
        $this->app->make('events')->subscribe('Anomaly\Streams\Platform\Ui\Table\Subscriber\TableQueryingSubscriber');
        $this->app->make('events')->subscribe('Anomaly\Streams\Platform\Ui\Table\Subscriber\TablePostSubscriber');
    }
}

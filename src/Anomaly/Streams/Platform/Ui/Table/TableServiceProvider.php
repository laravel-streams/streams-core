<?php namespace Anomaly\Streams\Platform\Ui\Table;

use Illuminate\Support\ServiceProvider;

class TableServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerListeners();
    }

    protected function registerListeners()
    {
        $this->app['events']->listen(
            'Anomaly.Streams.Platform.Ui.Table.Event.*',
            'Anomaly\Streams\Platform\Ui\Table\TableListener'
        );
    }
}

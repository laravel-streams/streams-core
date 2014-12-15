<?php namespace Anomaly\Streams\Platform\Ui\Table;

use Illuminate\Support\ServiceProvider;

/**
 * Class TableServiceProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table
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
        $this->registerListeners();
    }

    /**
     * Register the table listener.
     */
    protected function registerListeners()
    {
        $this->app->make('events')->listen(
            'Anomaly.Streams.Platform.Ui.Table.Event.*',
            'Anomaly\Streams\Platform\Ui\Table\TableListener'
        );
    }
}

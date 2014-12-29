<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Column;

use Illuminate\Support\ServiceProvider;

/**
 * Class ColumnServiceProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Column
 */
class ColumnServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
    }

    /**
     * Register bindings.
     */
    protected function registerBindings()
    {
        $this->app->instance(
            'streams::table.column.factory',
            'Anomaly\Streams\Platform\Ui\Table\Component\Column\ColumnFactory'
        );
    }
}

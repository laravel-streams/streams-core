<?php namespace Anomaly\Streams\Platform\Ui\Button;

use Illuminate\Support\ServiceProvider;

/**
 * Class ButtonServiceProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Button
 */
class ButtonServiceProvider extends ServiceProvider
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
            'streams::table.button.factory',
            'Anomaly\Streams\Platform\Ui\Button\ButtonFactory'
        );

        $this->app->singleton(
            'Anomaly\Streams\Platform\Ui\Button\ButtonRegistry',
            'Anomaly\Streams\Platform\Ui\Button\ButtonRegistry'
        );
    }
}

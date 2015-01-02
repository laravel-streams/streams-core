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
     * Boot the service provider.
     */
    public function boot()
    {
        app('twig')->addExtension(app('Anomaly\Streams\Platform\Ui\Button\ButtonPlugin'));
    }

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

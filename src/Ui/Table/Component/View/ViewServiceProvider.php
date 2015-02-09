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
        $this->app->singleton(
            'Anomaly\Streams\Platform\Ui\Table\Component\View\ViewRegistry',
            'Anomaly\Streams\Platform\Ui\Table\Component\View\ViewRegistry'
        );

        $this->app->register('Anomaly\Streams\Platform\Ui\Table\Component\View\ViewEventProvider');
    }
}

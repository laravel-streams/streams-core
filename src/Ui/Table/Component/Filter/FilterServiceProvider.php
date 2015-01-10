<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter;

use Illuminate\Support\ServiceProvider;

/**
 * Class FilterServiceProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Filter
 */
class FilterServiceProvider extends ServiceProvider
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
        $this->app->singleton(
            'Anomaly\Streams\Platform\Ui\Table\Component\Filter\FilterRegistry',
            'Anomaly\Streams\Platform\Ui\Table\Component\Filter\FilterRegistry'
        );
    }
}

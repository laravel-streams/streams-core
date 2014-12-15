<?php namespace Anomaly\Streams\Platform\Field;

use Illuminate\Support\ServiceProvider;

/**
 * Class FieldServiceProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Field
 */
class FieldServiceProvider extends ServiceProvider
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
     * Register field management bindings.
     */
    protected function registerBindings()
    {
        $this->app->bind(
            'Anomaly\Streams\Platform\Field\FieldModel',
            config('streams::config.fields.model')
        );

        $this->app->bind(
            '\Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface',
            config('streams::config.fields.repository')
        );
    }
}

<?php namespace Anomaly\Streams\Platform\Field;

use Illuminate\Support\ServiceProvider;

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

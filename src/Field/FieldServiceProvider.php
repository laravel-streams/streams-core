<?php namespace Anomaly\Streams\Platform\Field;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Support\ServiceProvider;

/**
 * Class FieldServiceProvider
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Field
 */
class FieldServiceProvider extends ServiceProvider
{

    use DispatchesCommands;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'Anomaly\Streams\Platform\Field\FieldModel',
            'Anomaly\Streams\Platform\Field\FieldModel'
        );

        $this->app->singleton(
            'Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface',
            'Anomaly\Streams\Platform\Field\FieldRepository'
        );
    }
}

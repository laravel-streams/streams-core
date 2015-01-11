<?php namespace Anomaly\Streams\Platform\Model;

use Anomaly\Streams\Platform\Model\Command\ObserveEloquentModel;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Support\ServiceProvider;

/**
 * Class EloquentServiceProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Model
 */
class EloquentServiceProvider extends ServiceProvider
{

    use DispatchesCommands;

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->dispatch(new ObserveEloquentModel());
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }
}

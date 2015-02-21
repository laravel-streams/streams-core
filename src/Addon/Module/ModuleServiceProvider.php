<?php namespace Anomaly\Streams\Platform\Addon\Module;

use Anomaly\Streams\Platform\Addon\Module\Command\DetectActiveModule;
use Anomaly\Streams\Platform\Addon\Module\Command\RegisterModules;
use Anomaly\Streams\Platform\Addon\Module\Command\SetModuleStates;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Support\ServiceProvider;

/**
 * Class ModuleServiceProvider
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Module
 */
class ModuleServiceProvider extends ServiceProvider
{

    use DispatchesCommands;

    /**
     * Boot the service.
     */
    public function boot()
    {
        $this->dispatch(new RegisterModules());

        if (app('Anomaly\Streams\Platform\Application\Application')->isInstalled()) {
            $this->dispatch(new SetModuleStates());
            $this->dispatch(new DetectActiveModule());
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'Anomaly\Streams\Platform\Addon\Module\ModuleModel',
            config('streams::config.modules.model')
        );
        $this->app->bind(
            'Anomaly\Streams\Platform\Addon\Module\Contract\ModuleRepositoryInterface',
            config('streams::config.modules.repository')
        );
        $this->app->singleton(
            'Anomaly\Streams\Platform\Addon\Module\ModuleCollection',
            'Anomaly\Streams\Platform\Addon\Module\ModuleCollection'
        );

        $this->app->register('Anomaly\Streams\Platform\Addon\Module\ModuleEventProvider');
    }
}

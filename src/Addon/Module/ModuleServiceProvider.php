<?php namespace Anomaly\Streams\Platform\Addon\Module;

use Anomaly\Streams\Platform\Addon\Module\Command\DetectActiveModuleCommand;
use Anomaly\Streams\Platform\Addon\Module\Command\RegisterListenersCommand;
use Anomaly\Streams\Platform\Addon\Module\Command\RegisterModulesCommand;
use Anomaly\Streams\Platform\Addon\Module\Command\SetModuleStatesCommand;
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
        $this->dispatch(new RegisterListenersCommand());
        $this->dispatch(new RegisterModulesCommand());
        $this->dispatch(new SetModuleStatesCommand());
        $this->dispatch(new DetectActiveModuleCommand());
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
        $this->registerCollection();
    }

    /**
     * Register the module management bindings.
     */
    protected function registerBindings()
    {
        $this->app->bind(
            'Anomaly\Streams\Platform\Addon\Module\ModuleModel',
            config('streams::config.modules.model')
        );
        $this->app->bind(
            'Anomaly\Streams\Platform\Addon\Module\Contract\ModuleRepositoryInterface',
            config('streams::config.modules.repository')
        );
    }

    /**
     * Register the module collection.
     */
    protected function registerCollection()
    {
        $this->app->singleton(
            'Anomaly\Streams\Platform\Addon\Module\ModuleCollection',
            'Anomaly\Streams\Platform\Addon\Module\ModuleCollection'
        );
    }
}

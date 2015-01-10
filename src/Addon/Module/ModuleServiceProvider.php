<?php namespace Anomaly\Streams\Platform\Addon\Module;

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

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
        $this->registerListeners();
        $this->registerCollection();

        $this->registerModules();
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
     * Register the module listener.
     */
    protected function registerListeners()
    {
        $this->app->make('events')->listen(
            'streams::application.booting',
            'Anomaly\Streams\Platform\Addon\Module\Listener\ApplicationBootingListener'
        );

        $this->app->make('events')->listen(
            'streams::application.booting',
            'Anomaly\Streams\Platform\Addon\Module\Listener\ModulesRegisteredListener'
        );

        $this->app->make('events')->listen(
            'Anomaly\Streams\Platform\Stream\Event\ModuleWasInstalled',
            'Anomaly\Streams\Platform\Addon\Module\Listener\ModuleInstalledListener'
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

    /**
     * Register all module addons.
     */
    protected function registerModules()
    {
        $this->app->make('Anomaly\Streams\Platform\Addon\AddonManager')->register('module');
    }
}

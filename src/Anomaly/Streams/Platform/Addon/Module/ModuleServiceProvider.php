<?php namespace Anomaly\Streams\Platform\Addon\Module;

use Anomaly\Streams\Platform\Addon\Module\Event\ModulesHaveRegistered;
use Illuminate\Support\ServiceProvider;
use Laracasts\Commander\Events\DispatchableTrait;
use Laracasts\Commander\Events\EventGenerator;

/**
 * Class ModuleServiceProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Module
 */
class ModuleServiceProvider extends ServiceProvider
{
    use EventGenerator;
    use DispatchableTrait;

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

        $this->raise(new ModulesHaveRegistered());

        $this->dispatchEventsFor($this);
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
            'Anomaly.Streams.Platform.Application.Event.*',
            '\Anomaly\Streams\Platform\Addon\Module\ModuleListener'
        );

        $this->app->make('events')->listen(
            'Anomaly.Streams.Platform.Addon.*',
            '\Anomaly\Streams\Platform\Addon\Module\ModuleListener'
        );
        $this->app->make('events')->listen(
            'Anomaly.Streams.Platform.Addon.Module.Event.*',
            'Anomaly\Streams\Platform\Addon\Module\ModuleListener'
        );
    }

    /**
     * Register the module collection.
     */
    protected function registerCollection()
    {
        $this->app->instance('streams.modules', new ModuleCollection());
    }

    /**
     * Register all module addons.
     */
    protected function registerModules()
    {
        $this->app->make('streams.addon.manager')->register('module');
    }
}

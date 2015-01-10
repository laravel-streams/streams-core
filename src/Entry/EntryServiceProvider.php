<?php namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Entry\Command\AutoloadEntryModelsCommand;
use Anomaly\Streams\Platform\Entry\Command\ObserveEntryModelCommand;
use Composer\Autoload\ClassLoader;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Support\ServiceProvider;

/**
 * Class EntryServiceProvider
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Entry
 */
class EntryServiceProvider extends ServiceProvider
{

    use DispatchesCommands;

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->dispatch(new ObserveEntryModelCommand());
        $this->dispatch(new AutoloadEntryModelsCommand());
    }

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
     * Register entry management bindings.
     */
    protected function registerBindings()
    {
        $this->app->bind(
            'Anomaly\Streams\Platform\Entry\EntryModel',
            config('streams::config.entries.model')
        );
        $this->app->bind(
            'Anomaly\Streams\Platform\Entry\Contract\EntryRepositoryInterface',
            config('streams::config.entries.repository')
        );
    }
}

<?php namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Entry\Command\AutoloadEntryModels;
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
        $this->dispatch(new AutoloadEntryModels());
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'Anomaly\Streams\Platform\Entry\EntryModel',
            'Anomaly\Streams\Platform\Entry\EntryModel'
        );
        $this->app->bind(
            'Anomaly\Streams\Platform\Entry\Contract\EntryRepositoryInterface',
            'Anomaly\Streams\Platform\Entry\EntryRepository'
        );
    }
}

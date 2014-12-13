<?php namespace Anomaly\Streams\Platform\Entry;

use Composer\Autoload\ClassLoader;
use Illuminate\Support\ServiceProvider;

class EntryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
        $this->loadEntryModels();
    }

    protected function registerBindings()
    {
        $this->app->bind(
            'Anomaly\Streams\Platform\Entry\EntryModel',
            config('streams::config.entries.model')
        );

        $this->app->bind(
            '\Anomaly\Streams\Platform\Entry\Contract\EntryRepositoryInterface',
            config('streams::config.entries.repository')
        );
    }

    protected function loadEntryModels()
    {
        $loader = new ClassLoader();

        $loader->addPsr4(
            'Anomaly\Streams\Platform\Model\\',
            base_path('storage/models/streams/' . app('streams.application')->getReference())
        );

        $loader->register();
    }
}

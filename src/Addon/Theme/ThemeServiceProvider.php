<?php namespace Anomaly\Streams\Platform\Addon\Theme;

use Anomaly\Streams\Platform\Addon\Theme\Command\DetectActiveThemeCommand;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Support\ServiceProvider;

/**
 * Class ThemeServiceProvider
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Theme
 */
class ThemeServiceProvider extends ServiceProvider
{

    use DispatchesCommands;

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->dispatch(new DetectActiveThemeCommand());
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerListeners();
        $this->registerCollection();

        $this->registerThemes();
    }

    /**
     * Register the theme listener.
     */
    protected function registerListeners()
    {
        $this->app->make('events')->listen(
            'streams::application.booting',
            'Anomaly\Streams\Platform\Addon\Theme\Listener\ApplicationBootingListener'
        );
    }

    /**
     * Register the theme collection.
     */
    protected function registerCollection()
    {
        $this->app->singleton(
            'Anomaly\Streams\Platform\Addon\Theme\ThemeCollection',
            'Anomaly\Streams\Platform\Addon\Theme\ThemeCollection'
        );
    }

    /**
     * Register all theme addons.
     */
    protected function registerThemes()
    {
        $this->app->make('Anomaly\Streams\Platform\Addon\AddonManager')->register('theme');
    }
}

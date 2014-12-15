<?php namespace Anomaly\Streams\Platform\Addon\Theme;

use Anomaly\Streams\Platform\Addon\Theme\Event\ThemesHaveRegistered;
use Illuminate\Support\ServiceProvider;
use Laracasts\Commander\Events\DispatchableTrait;
use Laracasts\Commander\Events\EventGenerator;

/**
 * Class ThemeServiceProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Theme
 */
class ThemeServiceProvider extends ServiceProvider
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
        $this->registerListeners();
        $this->registerCollection();

        $this->registerThemes();

        $this->raise(new ThemesHaveRegistered());

        $this->dispatchEventsFor($this);
    }

    /**
     * Register the theme listener.
     */
    protected function registerListeners()
    {
        $this->app->make('events')->listen(
            'Anomaly.Streams.Platform.Application.Event.*',
            'Anomaly\Streams\Platform\Addon\Theme\ThemeListener'
        );
        $this->app->make('events')->listen(
            'Anomaly.Streams.Platform.Addon.*',
            'Anomaly\Streams\Platform\Addon\Theme\ThemeListener'
        );
    }

    /**
     * Register the theme collection.
     */
    protected function registerCollection()
    {
        $this->app->instance('streams.themes', new ThemeCollection());
    }

    /**
     * Register all theme addons.
     */
    protected function registerThemes()
    {
        $this->app->make('streams.addon.manager')->register('theme');
    }
}

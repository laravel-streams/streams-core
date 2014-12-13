<?php namespace Anomaly\Streams\Platform\Addon\Tag;

use Anomaly\Streams\Platform\Addon\Tag\Event\TagsHaveRegistered;
use Anomaly\Streams\Platform\Addon\Theme\ThemeCollection;
use Illuminate\Support\ServiceProvider;
use Laracasts\Commander\Events\DispatchableTrait;
use Laracasts\Commander\Events\EventGenerator;

class TagServiceProvider extends ServiceProvider
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

        $this->registerTags();

        $this->raise(new TagsHaveRegistered());

        $this->dispatchEventsFor($this);
    }

    protected function registerListeners()
    {
        $this->app->make('events')->listen(
            'Anomaly.Streams.Platform.Addon.*',
            '\Anomaly\Streams\Platform\Addon\Tag\TagListener'
        );
    }

    protected function registerCollection()
    {
        $this->app->instance('streams.tags', new ThemeCollection());
    }

    protected function registerTags()
    {
        $this->app->make('streams.addon.manager')->register('tag');
    }
}

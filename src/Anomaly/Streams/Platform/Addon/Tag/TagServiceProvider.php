<?php namespace Anomaly\Streams\Platform\Addon\Tag;

use Anomaly\Streams\Platform\Addon\Tag\Event\TagsHaveRegistered;
use Illuminate\Support\ServiceProvider;
use Laracasts\Commander\Events\DispatchableTrait;
use Laracasts\Commander\Events\EventGenerator;

/**
 * Class TagServiceProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Tag
 */
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

    /**
     * Register the tag listner.
     */
    protected function registerListeners()
    {
        $this->app->make('events')->listen(
            'Anomaly.Streams.Platform.Addon.*',
            'Anomaly\Streams\Platform\Addon\Tag\TagListener'
        );
    }

    /**
     * Register the tag collection.
     */
    protected function registerCollection()
    {
        $this->app->instance('streams.tags', new TagCollection());
    }

    /**
     * Register all tag addons.
     */
    protected function registerTags()
    {
        $this->app->make('streams.addon.manager')->register('tag');
    }
}

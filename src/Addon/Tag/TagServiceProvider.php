<?php namespace Anomaly\Streams\Platform\Addon\Tag;

use Illuminate\Support\ServiceProvider;

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
    }

    /**
     * Register the tag listener.
     */
    protected function registerListeners()
    {
        $this->app->make('events')->listen(
            'streams::tags.registered',
            'Anomaly\Streams\Platform\Addon\Tag\Listener\TagsRegisteredListener'
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

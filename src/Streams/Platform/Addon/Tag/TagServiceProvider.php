<?php namespace Streams\Platform\Addon\Tag;

use Streams\Platform\Addon\AddonServiceProvider;

class TagServiceProvider extends AddonServiceProvider
{
    protected function onAfterRegister()
    {
        foreach ($this->app->make('streams.tags')->all() as $tag) {

            $tag = $tag->getResource();

            $slug     = $tag->getSlug();
            $abstract = $tag->getAbstract();

            $this->app->make('anomaly.lexicon')->registerPlugin($slug, $abstract);

        }
    }
}

<?php namespace Anomaly\Streams\Platform\Addon\Tag;

use Anomaly\Streams\Platform\Addon\AddonServiceProvider;

class TagServiceProvider extends AddonServiceProvider
{
    protected function onAfterRegister()
    {
        foreach ($this->app->make('streams.tags')->all() as $tag) {
            
            $this->app->make('anomaly.lexicon')->registerPlugin($tag->getSlug(), $tag->getAbstract());

        }
    }
}

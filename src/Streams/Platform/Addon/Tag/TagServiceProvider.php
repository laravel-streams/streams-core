<?php namespace Streams\Platform\Addon\Tag;

use Streams\Platform\Addon\AddonServiceProvider;

class TagServiceProvider extends AddonServiceProvider
{
    protected function onAfterRegister()
    {
        foreach (app('streams.tag.loaded') as $abstract) {
            $tag = app($abstract);

            app('anomaly.lexicon')->registerPlugin($tag->getSlug(), get_class($tag));
        }
    }
}

<?php namespace Anomaly\Streams\Platform\Addon\Tag;

use Laracasts\Commander\Events\EventListener;

/**
 * Class TagListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Tag
 */
class TagListener extends EventListener
{
    public function whenTagsHaveRegistered()
    {
        foreach (app('streams.tags') as $tag) {
            app('anomaly.lexicon')->registerPlugin($tag->getSlug(), 'tag.' . $tag->getSlug());
        }
    }
}

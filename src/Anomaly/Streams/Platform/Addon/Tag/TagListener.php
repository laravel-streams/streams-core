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
    /**
     * Fired when all tags have been registered.
     */
    public function whenTagsHaveRegistered()
    {
        foreach (app('streams.tags') as $tag) {
            $this->registerLexiconPlugin($tag);
        }
    }

    /**
     * Register an addon to the Lexicon parsing engine.
     *
     * @param Tag $tag
     */
    protected function registerLexiconPlugin(Tag $tag)
    {
        app('Anomaly\Lexicon\Contract\LexiconInterface')->registerPlugin($tag->getSlug(), $tag->getAbstract());
    }
}

<?php namespace Anomaly\Streams\Platform\Addon\Tag\Listener;

use Anomaly\Lexicon\Contract\LexiconInterface;
use Anomaly\Streams\Platform\Addon\Tag\Tag;

/**
 * Class TagsRegisteredListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Tag\Listener
 */
class TagsRegisteredListener
{

    /**
     * Lexicon
     *
     * @var LexiconInterface
     */
    protected $lexicon;

    /**
     * Create a new TagsRegisteredListener instance.
     *
     * @param LexiconInterface $lexicon
     */
    public function __construct(LexiconInterface $lexicon)
    {
        $this->lexicon = $lexicon;
    }

    /**
     * After all the tags have been registered
     * we need to register them as Lexicon plugins.
     */
    public function handle()
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
        $this->lexicon->registerPlugin($tag->getSlug(), $tag->getAbstract());
    }
}

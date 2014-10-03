<?php namespace Streams\Platform\Addon\Tag;

use Illuminate\Container\Container;
use Streams\Platform\Addon\AddonManager;

class TagManager extends AddonManager
{
    /**
     * The folder within addons locations to load tags from.
     *
     * @var string
     */
    protected $folder = 'tags';

    /**
     * Register the tag with Lexicon.
     *
     * @param Container $app
     */
    public function onAfterRegister(Container $app)
    {
        foreach ($this->all() as $tag) {
            app('anomaly.lexicon')->registerPlugin($tag->slug, get_class($tag->getResource()));
        }
    }

    /**
     * Return a new model instance.
     *
     * @return mixed
     */
    protected function newModel()
    {
        return new TagModel();
    }

    /**
     * Return a new collection instance.
     *
     * @param array $tags
     * @return null|TagCollection
     */
    protected function newCollection(array $tags = [])
    {
        return new TagCollection($tags);
    }
}

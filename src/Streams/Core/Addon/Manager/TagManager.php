<?php namespace Streams\Platform\Addon\Manager;

use Streams\Platform\Addon\Model\TagModel;
use Illuminate\Container\Container;
use Streams\Platform\Addon\Collection\TagCollection;

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
        foreach ($this->getClasses() as $slug => $class) {
            if (isset($this->data[$slug]) and $this->data[$slug]->is_installed) {
                $app['anomaly.lexicon']->registerPlugin($slug, $class);
            }
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

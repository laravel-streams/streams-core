<?php namespace Anomaly\Streams\Platform\Addon\Tag;

use Anomaly\Lexicon\Contract\LexiconInterface;
use Anomaly\Lexicon\Contract\Plugin\PluginInterface;
use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Addon\Tag\Attribute\AttributeCollection;

/**
 * Class Tag
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Tag
 */
class Tag extends Addon implements PluginInterface
{
    /**
     * A collection of the tag's attributes.
     *
     * @var AttributeCollection
     */
    protected $attributes = null;

    /**
     * The content within a filter or
     * parse block tag.
     *
     * @var null
     */
    protected $content = null;

    /**
     * The Lexicon object.
     *
     * Lexicon is the parser for Streams tags.
     *
     * @var null
     */
    protected $lexicon = null;

    /**
     * The plugin name for external parsers.
     *
     * @var null
     */
    protected $pluginName = null;

    /**
     * Set the attributes array.
     *
     * @param array $attributes
     * @return $this
     */
    public function setAttributes(array $attributes = [])
    {
        $this->attributes = new AttributeCollection($attributes);

        return $this;
    }

    /**
     * Get the attributes array.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Get an attribute.
     *
     * @param      $key
     * @param null $default
     * @param int  $offset
     * @return mixed
     */
    public function getAttribute($key, $default = null, $offset = 0)
    {
        return $this->attributes->get($key);
    }

    /**
     * Set the content between a filter / parse block.
     *
     * @param string $content
     * @return $this
     */
    public function setContent($content = '')
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the content between a filter / parse block.
     *
     * @return null
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the plugin from outside parsers.
     *
     * @param $pluginName
     * @return $this
     */
    public function setPluginName($pluginName)
    {
        $this->pluginName = $pluginName;

        return $this;
    }

    /**
     * Get plugin name for external parsers.
     *
     * @return null
     */
    public function getPluginName()
    {
        return $this->pluginName;
    }

    /**
     * Set the Lexicon parser object.
     *
     * @param LexiconInterface $lexicon
     * @return $this
     */
    public function setEnvironment(LexiconInterface $lexicon)
    {
        $this->lexicon = $lexicon;

        return $this;
    }

    /**
     * Determine if this tag is a filter.
     *
     * Individual methods can also be defined
     * like:
     *
     * public function filterFoo();
     *
     * @param $key
     * @return bool
     */
    public function isFilter($key)
    {
        return false;
    }

    /**
     * Determine if this tag is a filter.
     *
     * Individual methods can also be defined
     * like:
     *
     * public function parseFoo();
     *
     * @param $key
     * @return bool
     */
    public function isParse($key)
    {
        return false;
    }

    /**
     * By default return null on invalid calls.
     *
     * @param       $key
     * @param array $params
     * @return null
     */
    public function __call($key, array $params = [])
    {
        return null;
    }
}

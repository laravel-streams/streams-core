<?php namespace Anomaly\Streams\Platform\Addon\Tag;

use Anomaly\Lexicon\Contract\LexiconInterface;
use Anomaly\Lexicon\Contract\Plugin\PluginInterface;
use Anomaly\Streams\Platform\Addon\Addon;

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
     * An array of the tag's attributes.
     *
     * @var array
     */
    protected $attributes = [];

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
        $this->attributes = $attributes;

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
     * Get the attributes array except
     * the skipped values.
     *
     * $skip is $offset => $name oriented to
     * allow skipping offsets too.
     *
     * @param array $skip
     * @return array
     */
    public function getAttributesExcept(array $skip)
    {
        $attributes = $this->attributes;

        foreach ($attributes as $key => $attribute) {

            if (in_array($key, $skip) || isset($skip[$key])) {

                unset($attributes[$key]);
            }
        }

        return $attributes;
    }

    /**
     * Get a single attribute value.
     *
     * @param      $name
     * @param null $default
     * @param int  $offset
     * @return null
     */
    public function getAttribute($name, $default = null, $offset = 0)
    {
        if (isset($this->attributes[$name])) {

            return $this->attributes[$name];
        } elseif (isset($this->attributes[$offset])) {

            return $this->attributes[$offset];
        }

        return $default;
    }

    /**
     * Get a single attribute exploded into
     * an array of key values.
     *
     * Like: foo=bar|baz=blah
     *
     * @param        $name
     * @param null   $default
     * @param int    $offset
     * @param string $itemDelimiter
     * @param string $valueDelimiter
     * @return array
     */
    public function getAttributeAsArray(
        $name,
        $default = [],
        $offset = 0,
        $itemDelimiter = '|',
        $valueDelimiter = '='
    ) {
        // Get the string and explode it.
        $value = $this->getAttribute($name, $default, $offset);

        if (is_string($value)) {

            return $this->explode(
                $value,
                $itemDelimiter,
                $valueDelimiter
            );
        }

        // If an array was passed.. Can't remember if
        // this is even possible, just use it.
        if (is_array($value)) {

            return $value;
        }

        return $default;
    }

    /**
     * Get an attribute value evaluated
     * as a boolean.
     *
     * @param      $name
     * @param null $default
     * @param int  $offset
     * @return mixed
     */
    public function getAttributeAsBool($name, $default = null, $offset = 0)
    {
        return ($this->getAttribute($name, $default, $offset));
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
     * Explode a string into an array or key / values.
     *
     * @param        $string
     * @param string $itemDelimiter
     * @param string $valueDelimiter
     * @return array
     */
    public function explode($string, $itemDelimiter = '|', $valueDelimiter = '=')
    {
        $array = [];

        $values = explode($itemDelimiter, $string);

        foreach ($values as $k => $item) {

            $item = explode($valueDelimiter, $item);

            // If there is no key - use the original index.
            $array[count($item) > 1 ? $item[0] : $k] = count($item) > 1 ? $item[1] : $item[0];
        }

        return $array;
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

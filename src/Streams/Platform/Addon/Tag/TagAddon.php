<?php namespace Streams\Platform\Addon\Tag;

use Streams\Platform\Addon\Addon;
use Anomaly\Lexicon\Contract\LexiconInterface;
use Streams\Platform\Contract\PresentableInterface;
use Anomaly\Lexicon\Contract\Plugin\PluginInterface;

class TagAddon extends Addon implements PluginInterface, PresentableInterface
{
    protected $type = 'tag';

    protected $slug = null;

    protected $attributes = [];

    protected $content = null;

    protected $lexicon = null;

    public function except($keys = [])
    {
        $attributes = $this->attributes;

        foreach ($attributes as $key => $attribute) {
            if (in_array($key, $keys) or isset($keys[$key])) {
                unset($attributes[$key]);
            }
        }

        return $attributes;
    }

    public function parseIntoArray($string)
    {
        $values = explode('|', $string);

        $array = [];

        foreach ($values as $k => $item) {
            $item = explode('=', $item);

            // If there is no key - use the original index
            $array[count($item) > 1 ? $item[0] : $k] = count($item) > 1 ? $item[1] : $item[0];
        }

        return $array;
    }

    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function setContent($content = '')
    {
        $this->content = $content;

        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getAttribute($name, $offset = 0, $default = null)
    {
        if (isset($this->attributes[$name])) {
            return $this->attributes[$name];
        } elseif (isset($this->attributes[$offset])) {
            return $this->attributes[$offset];
        }

        return $default;
    }

    public function getAttributeAsArray($attribute, $offset = 0, $default = null)
    {
        $attribute = $this->getAttribute($attribute, $offset, $default);

        return $attribute ? $this->parseIntoArray($attribute) : [];
    }

    public function getAttributeAsBoolean($attribute, $offset = 0, $default = null)
    {
        return filter_var($this->getAttribute($attribute, $offset, $default), FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * This method is used internally by lexicon to set the plugin name,
     * rare cases where the plugin is sent directly to a view
     *
     * @param $name
     * @return $this
     */
    public function setPluginName($name)
    {
        $this->slug = $name;

        return $this;
    }

    /**
     * Return the slug as the tag name for Lexicon.
     *
     * @return string
     */
    public function getPluginName()
    {
        return $this->slug;
    }

    /**
     * Set the Lexicon environment.
     *
     * @param LexiconInterface $lexicon
     * @return $this|mixed
     */
    public function setEnvironment(LexiconInterface $lexicon)
    {
        $this->lexicon = $lexicon;

        return $this;
    }

    public function newPresenter()
    {
        return new TagPresenter($this);
    }

    /**
     * @param $key
     * @return mixed
     */
    public function isFilter($key)
    {
        //
    }

    /**
     * @param $key
     * @return mixed
     */
    public function isParse($key)
    {
        //
    }

    public function __call($key, array $params = [])
    {
        return null;
    }
}

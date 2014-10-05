<?php namespace Streams\Platform\Addon\Tag;

use Streams\Platform\Addon\Addon;
use Anomaly\Lexicon\Contract\PluginInterface;
use Anomaly\Lexicon\Contract\LexiconInterface;

class TagAddon extends Addon implements PluginInterface
{
    protected $slug = null;

    protected $attributes = [];

    protected $content = null;

    protected $lexicon = null;

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

        return $this->parseIntoArray($attribute);
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

    public function newServiceProvider()
    {
        return new TagServiceProvider($this->app);
    }

    /**
     * If a method does not exist - fail silently.
     *
     * @param $name
     * @param $arguments
     * @return null
     */
    public function __call($name, $arguments)
    {
        return null;
    }
}

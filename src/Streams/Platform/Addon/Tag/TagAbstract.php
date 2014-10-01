<?php namespace Streams\Platform\Addon\Tag;

use Streams\Platform\Addon\AddonAbstract;
use Streams\Platform\Addon\Model\TagModel;
use Anomaly\Lexicon\Contract\PluginInterface;
use Anomaly\Lexicon\Contract\LexiconInterface;
use Streams\Platform\Addon\Presenter\TagPresenter;

abstract class TagAbstract extends AddonAbstract implements PluginInterface
{
    /**
     * Attributes that have been passed into the tag.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Content inside the tag block.
     *
     * @var
     */
    protected $content = null;

    /**
     * Get an attribute or it's default by name or offset.
     *
     * @param      $name
     * @param null $default
     * @param int  $offset
     * @return null
     */
    public function getAttribute($name, $offset = 0, $default = null)
    {
        if (isset($this->attributes[$name])) {
            return $this->attributes[$name];
        } elseif (isset($this->attributes[$offset])) {
            return $this->attributes[$offset];
        }

        return $default;
    }

    /**
     * Get an attribute as an array or it's default by name or offset.
     *
     * @param      $attribute
     * @param int  $offset
     * @param null $default
     * @return array
     */
    public function asArray($attribute, $offset = 0, $default = null)
    {
        $attribute = $this->getAttribute($attribute, $offset, $default);

        return $this->toArray($attribute);
    }

    /**
     * Return an string as an array.
     *
     * @param $string
     * @return array
     */
    public function toArray($string)
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

    /**
     * Get an attribute as a boolean value or it's default by name or offset.
     *
     * @param      $attribute
     * @param int  $offset
     * @param null $default
     */
    public function asBoolean($attribute, $offset = 0, $default = null)
    {
        return filter_var($this->getAttribute($attribute, $offset, $default), FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Return attributes except select keys.
     *
     * @param $keys
     * @return array
     */
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

    /**
     * Set the content of the plugin.
     *
     * @param string $content
     */
    public function setContent($content = '')
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Set attributes for the plugin.
     *
     * @param array $attributes
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
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
     * Return a new TagModel instance.
     *
     * @return null|TagModel
     */
    public function newModel()
    {
        return new TagModel();
    }

    /**
     * Return a new presenter instance.
     *
     * @param $resource
     * @return null|TagPresenter
     */
    public function newPresenter($resource)
    {
        return new TagPresenter($resource);
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

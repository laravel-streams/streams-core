<?php namespace Streams\Platform\Addon\Tag;

use Streams\Platform\Addon\Addon;
use Anomaly\Lexicon\Contract\LexiconInterface;
use Streams\Platform\Contract\PresentableInterface;
use Anomaly\Lexicon\Contract\Plugin\PluginInterface;

class TagAddon extends Addon implements PluginInterface, PresentableInterface
{
    protected $pluginName = null;

    protected $attributes = [];

    protected $content = null;

    protected $lexicon = null;

    public function parse($string)
    {
        $values = explode('|', $string);

        $array = [];

        foreach ($values as $k => $item) {

            $item = explode('=', $item);

            // If there is no key - use the original index.
            $array[count($item) > 1 ? $item[0] : $k] = count($item) > 1 ? $item[1] : $item[0];

        }

        return $array;
    }

    public function setAttributes(array $attributes = [])
    {
        $this->attributes = $attributes;

        return $this;
    }

    public function getAttributes()
    {
        return $this->attributes;
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

    public function setContent($content = '')
    {
        $this->content = $content;

        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function newPresenter()
    {
        return new TagPresenter($this);
    }

    public function __call($key, array $params = [])
    {
        return null;
    }

    public function setPluginName($pluginName)
    {
        $this->pluginName = $pluginName;

        return $this;
    }

    public function getPluginName()
    {
        return $this->pluginName;
    }

    public function setEnvironment(LexiconInterface $lexicon)
    {
        $this->lexicon = $lexicon;

        return $this;
    }

    public function isFilter($key)
    {
        return false;
    }

    public function isParse($key)
    {
        return false;
    }
}

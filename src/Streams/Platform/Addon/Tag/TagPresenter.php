<?php namespace Streams\Platform\Addon\Tag;

use Streams\Platform\Addon\AddonPresenter;
use Anomaly\Lexicon\Contract\Plugin\PluginInterface;

class TagPresenter extends AddonPresenter implements PluginInterface
{

    public function setPluginName($pluginName)
    {
        parent::setPluginName($pluginName);
    }

    public function getPluginName()
    {
        parent::__FUNCTIOgetPluginNameN__();
    }

    public function setContent($content)
    {
        parent::setContent($content);
    }

    public function setAttributes(array $attributes)
    {
        parent::setAttributes($attributes);
    }

    public function getAttribute($name, $offset = 0, $default = null)
    {
        parent::getAttribute($name, $offset, $default);
    }

    public function isFilter($key)
    {
        parent::isFilter($key);
    }

    public function isParse($key)
    {
        parent::isParse($key);
    }

    public function __call($key, array $params = [])
    {
        parent::__call($key, $params);
    }

}
 
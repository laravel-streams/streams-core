<?php namespace Anomaly\Streams\Platform\Addon\Tag;

use Anomaly\Streams\Platform\Addon\AddonPresenter;
use Anomaly\Lexicon\Contract\Plugin\PluginInterface;

class TagPresenter extends AddonPresenter implements PluginInterface
{

    public function setPluginName($pluginName)
    {
        return parent::setPluginName($pluginName);
    }

    public function getPluginName()
    {
        return parent::__FUNCTIOgetPluginNameN__();
    }

    public function setContent($content)
    {
        return parent::setContent($content);
    }

    public function setAttributes(array $attributes)
    {
        return parent::setAttributes($attributes);
    }

    public function getAttribute($name, $offset = 0, $default = null)
    {
        return parent::getAttribute($name, $offset, $default);
    }

    public function isFilter($key)
    {
        return parent::isFilter($key);
    }

    public function isParse($key)
    {
        return parent::isParse($key);
    }

    public function __call($key, array $params = [])
    {
        return parent::__call($key, $params);
    }

}
 
<?php namespace Anomaly\Streams\Platform\Ui\Button;

use Anomaly\Streams\Platform\Ui\Button\Contract\ButtonInterface;

class Button implements ButtonInterface
{

    protected $text;

    protected $icon;

    protected $type;

    protected $class;

    protected $attributes;

    function __construct($type = 'default', $text = null, $class = null, $icon = null, array $attributes = [])
    {
        $this->icon       = $icon;
        $this->class      = $class;
        $this->text       = $text;
        $this->type       = $type;
        $this->attributes = $attributes;
    }

    public function viewData()
    {
        $type  = $this->getType();
        $icon  = $this->getIcon();
        $class = $this->getClass();

        $text = trans($this->getText());

        $attributes = attributes_string($this->getAttributes());

        return compact('text', 'type', 'class', 'icon', 'attributes');
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

    public function putAttribute($key, $attribute)
    {
        $this->attributes[$key] = $attribute;

        return $this;
    }

    public function pullAttribute($key, $default = null)
    {
        return array_get($this->attributes, $key, $default);
    }

    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    public function getIcon()
    {
        return $this->icon;
    }

    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    public function getClass()
    {
        return $this->class;
    }
}

 
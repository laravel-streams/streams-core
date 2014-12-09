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

    public function viewData(array $arguments = [])
    {
        $type       = $this->getType();
        $icon       = $this->getIcon();
        $text       = $this->getText();
        $class      = $this->getClass();
        $attributes = $this->getAttributes();

        if (is_string($text)) {

            $text = trans($text);
        }

        return evaluate(compact('text', 'type', 'class', 'icon', 'attributes'), $arguments);
    }

    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    public function getAttributes()
    {
        return $this->attributes;
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

    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    public function getIcon()
    {
        return $this->icon;
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
}

 
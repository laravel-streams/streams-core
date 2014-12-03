<?php namespace Anomaly\Streams\Platform\Ui\Button;

use Anomaly\Streams\Platform\Ui\Button\Contract\ButtonInterface;
use Anomaly\Streams\Platform\Ui\Icon\Contract\IconInterface;

class Button implements ButtonInterface
{

    protected $text;

    protected $class;

    protected $size;

    protected $icon;

    function __construct($class, $text = null, $size = null, IconInterface $icon = null)
    {
        $this->text  = $text;
        $this->icon  = $icon;
        $this->size  = $size;
        $this->class = $class;
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

    public function setIcon(IconInterface $icon)
    {
        $this->icon = $icon;

        return $this;
    }

    public function getIcon()
    {
        return $this->icon;
    }

    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    public function getSize()
    {
        return $this->size;
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
}
 
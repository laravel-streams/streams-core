<?php namespace Anomaly\Streams\Platform\Ui\Form\Tab;

use Anomaly\Streams\Platform\Ui\Form\Layout\Contract\LayoutInterface;
use Anomaly\Streams\Platform\Ui\Form\Tab\Contract\TabInterface;

class Tab implements TabInterface
{

    protected $text;

    protected $layout;

    function __construct($text, LayoutInterface $layout)
    {
        $this->text   = $text;
        $this->layout = $layout;
    }

    public function viewData()
    {
        $text   = $this->getText();
        $layout = $this->layout->viewData();

        return compact('text', 'layout');
    }

    public function setLayout(LayoutInterface $layout)
    {
        $this->layout = $layout;

        return $this;
    }

    public function getLayout()
    {
        return $this->layout;
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
 
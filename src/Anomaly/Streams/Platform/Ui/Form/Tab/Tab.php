<?php namespace Anomaly\Streams\Platform\Ui\Form\Tab;

use Anomaly\Streams\Platform\Ui\Form\Tab\Contract\TabInterface;

class Tab implements TabInterface
{

    protected $text;

    function __construct($text)
    {
        $this->text = $text;
    }

    public function viewData(array $arguments = [])
    {
        $text = $this->getText();

        return compact('text', 'layout');
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
 
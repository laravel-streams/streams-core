<?php namespace Anomaly\Streams\Platform\Ui\Button\Command;

class ParseButtonInputCommand
{

    protected $buttons;

    function __construct(array $buttons)
    {
        $this->buttons = $buttons;
    }

    public function getButtons()
    {
        return $this->buttons;
    }
}
 
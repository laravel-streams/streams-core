<?php namespace Anomaly\Streams\Platform\Ui\Table\Action\Command;

class ParseActionInputCommand
{

    protected $actions;

    function __construct(array $actions)
    {
        $this->actions = $actions;
    }

    public function getActions()
    {
        return $this->actions;
    }
}
 
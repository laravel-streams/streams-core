<?php namespace Anomaly\Streams\Platform\Ui\Table\Action\Command;

class MakeActionCommand
{

    protected $parameters;

    function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    public function getParameters()
    {
        return $this->parameters;
    }
}
 
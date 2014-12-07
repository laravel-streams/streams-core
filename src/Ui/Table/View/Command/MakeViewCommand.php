<?php namespace Anomaly\Streams\Platform\Ui\Table\View\Command;

class MakeViewCommand
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
 
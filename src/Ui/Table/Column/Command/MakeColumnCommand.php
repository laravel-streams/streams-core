<?php namespace Anomaly\Streams\Platform\Ui\Table\Column\Command;

class MakeColumnCommand
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
 
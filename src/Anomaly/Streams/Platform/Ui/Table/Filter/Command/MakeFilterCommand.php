<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter\Command;

class MakeFilterCommand
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
 
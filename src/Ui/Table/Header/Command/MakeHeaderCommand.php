<?php namespace Anomaly\Streams\Platform\Ui\Table\Header\Command;

class MakeHeaderCommand
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
 
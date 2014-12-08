<?php namespace Anomaly\Streams\Platform\Ui\Form\Button\Command;

class MakeButtonCommand
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
 
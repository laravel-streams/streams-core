<?php namespace Anomaly\Streams\Platform\Ui\Form\Section\Command;

class MakeSectionCommand
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
 
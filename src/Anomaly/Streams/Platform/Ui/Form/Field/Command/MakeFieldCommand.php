<?php namespace Anomaly\Streams\Platform\Ui\Form\Field\Command;

class MakeFieldCommand
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
 
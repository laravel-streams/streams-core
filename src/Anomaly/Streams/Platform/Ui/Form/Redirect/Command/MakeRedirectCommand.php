<?php namespace Anomaly\Streams\Platform\Ui\Form\Redirect\Command;

class MakeRedirectCommand
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
 
<?php namespace Anomaly\Streams\Platform\Ui\Form\Action\Command;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

class StandardizeActionInputCommand
{

    protected $builder;

    function __construct(FormBuilder $builder)
    {
        $this->builder = $builder;
    }

    public function getBuilder()
    {
        return $this->builder;
    }
}
 
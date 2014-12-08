<?php namespace Anomaly\Streams\Platform\Ui\Form\Field\Command;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

class StandardizeFieldInputCommand
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
 
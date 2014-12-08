<?php namespace Anomaly\Streams\Platform\Ui\Form\Button\Command;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

class StandardizeButtonInputCommand
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
 
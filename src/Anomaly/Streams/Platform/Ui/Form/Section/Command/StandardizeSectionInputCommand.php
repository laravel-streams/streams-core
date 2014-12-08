<?php namespace Anomaly\Streams\Platform\Ui\Form\Section\Command;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

class StandardizeSectionInputCommand
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
 
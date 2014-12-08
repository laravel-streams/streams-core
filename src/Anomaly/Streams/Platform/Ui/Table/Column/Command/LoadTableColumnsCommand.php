<?php namespace Anomaly\Streams\Platform\Ui\Table\Column\Command;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

class LoadTableColumnsCommand
{

    protected $builder;

    function __construct(TableBuilder $builder)
    {
        $this->builder = $builder;
    }

    public function getBuilder()
    {
        return $this->builder;
    }
}
 
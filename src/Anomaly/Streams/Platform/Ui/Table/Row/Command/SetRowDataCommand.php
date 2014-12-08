<?php namespace Anomaly\Streams\Platform\Ui\Table\Row\Command;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

class SetRowDataCommand
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
 
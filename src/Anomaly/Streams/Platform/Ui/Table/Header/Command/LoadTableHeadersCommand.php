<?php namespace Anomaly\Streams\Platform\Ui\Table\Header\Command;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

class LoadTableHeadersCommand
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
 
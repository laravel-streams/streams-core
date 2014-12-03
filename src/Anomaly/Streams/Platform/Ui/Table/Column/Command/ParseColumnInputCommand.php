<?php namespace Anomaly\Streams\Platform\Ui\Table\Column\Command;

class ParseColumnInputCommand
{

    protected $columns;

    function __construct(array $columns)
    {
        $this->columns = $columns;
    }

    public function getColumns()
    {
        return $this->columns;
    }
}
 
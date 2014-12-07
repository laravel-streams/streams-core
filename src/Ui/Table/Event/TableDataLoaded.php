<?php namespace Anomaly\Streams\Platform\Ui\Table\Event;

use Anomaly\Streams\Platform\Ui\Table\Table;

class TableDataLoaded
{

    protected $table;

    function __construct(Table $table)
    {
        $this->table = $table;
    }

    public function getTable()
    {
        return $this->table;
    }
}
 
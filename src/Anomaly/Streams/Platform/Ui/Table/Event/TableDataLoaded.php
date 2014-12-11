<?php namespace Anomaly\Streams\Platform\Ui\Table\Event;

use Anomaly\Streams\Platform\Ui\Table\Table;

class TableDataLoaded
{
    protected $table;

    public function __construct(Table $table)
    {
        $this->table = $table;
    }

    public function getTable()
    {
        return $this->table;
    }
}

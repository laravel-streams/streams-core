<?php namespace Anomaly\Streams\Platform\Stream\Command;

class CreateStreamsEntryTableCommand
{
    protected $table;

    function __construct($table)
    {
        $this->table = $table;
    }

    public function getTable()
    {
        return $this->table;
    }
}
 
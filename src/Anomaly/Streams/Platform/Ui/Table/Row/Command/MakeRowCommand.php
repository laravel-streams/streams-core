<?php namespace Anomaly\Streams\Platform\Ui\Table\Row\Command;

use Anomaly\Streams\Platform\Ui\Table\Button\ButtonCollection;
use Anomaly\Streams\Platform\Ui\Table\Column\ColumnCollection;

class MakeRowCommand
{

    protected $entry;

    protected $columns;

    protected $buttons;

    function __construct($entry, ButtonCollection $buttons, ColumnCollection $columns)
    {
        $this->entry   = $entry;
        $this->buttons = $buttons;
        $this->columns = $columns;
    }

    public function getButtons()
    {
        return $this->buttons;
    }

    public function getColumns()
    {
        return $this->columns;
    }

    public function getEntry()
    {
        return $this->entry;
    }
}
 
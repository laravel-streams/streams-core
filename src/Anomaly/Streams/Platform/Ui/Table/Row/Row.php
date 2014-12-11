<?php namespace Anomaly\Streams\Platform\Ui\Table\Row;

use Anomaly\Streams\Platform\Contract\ArrayableInterface;
use Anomaly\Streams\Platform\Ui\Button\ButtonCollection;
use Anomaly\Streams\Platform\Ui\Button\Contract\ButtonInterface;
use Anomaly\Streams\Platform\Ui\Table\Column\ColumnCollection;
use Anomaly\Streams\Platform\Ui\Table\Column\Contract\ColumnInterface;
use Anomaly\Streams\Platform\Ui\Table\Row\Contract\RowInterface;

class Row implements RowInterface
{
    protected $entry;

    protected $columns;

    protected $buttons;

    public function __construct($entry, ButtonCollection $buttons, ColumnCollection $columns)
    {
        $this->entry   = $entry;
        $this->buttons = $buttons;
        $this->columns = $columns;
    }

    public function viewData(array $arguments = [])
    {
        $entry   = [];
        $buttons = [];
        $columns = [];

        if ($this->entry instanceof ArrayableInterface) {
            $entry = $this->entry->toArray();
        }

        foreach ($this->buttons as $button) {
            if ($button instanceof ButtonInterface) {
                $buttons[] = $button->viewData(['entry' => $this->entry]);
            }
        }

        foreach ($this->columns as $column) {
            if ($column instanceof ColumnInterface) {
                $column->setEntry($this->entry);

                $columns[] = $column->viewData(['entry' => $this->entry]);
            }
        }

        return compact('buttons', 'columns', 'entry');
    }
}

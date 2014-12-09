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

    function __construct($entry, ButtonCollection $buttons, ColumnCollection $columns)
    {
        $this->entry   = $entry;
        $this->buttons = $buttons;
        $this->columns = $columns;
    }

    public function viewData()
    {
        $entry   = [];
        $buttons = [];
        $columns = [];

        if ($this->entry instanceof ArrayableInterface) {

            $entry = $this->entry->toArray();
        }

        foreach ($this->buttons as $button) {

            if ($button instanceof ButtonInterface) {

                $button = evaluate($button->viewData(), ['entry' => $this->entry]);

                $button['attributes'] = attributes_string($button['attributes']);

                if (array_get($button, 'enabled') === false) {

                    continue;
                }

                $buttons[] = $button;
            }
        }

        foreach ($this->columns as $column) {

            if ($column instanceof ColumnInterface) {

                $column->setEntry($this->entry);

                $column = evaluate($column->viewData(), ['entry' => $this->entry]);

                if (array_get($column, 'enabled') === false) {

                    continue;
                }

                $columns[] = $column;
            }
        }

        return compact('buttons', 'columns', 'entry');
    }
}
 
<?php namespace Anomaly\Streams\Platform\Ui\Table\Row;

use Anomaly\Streams\Platform\Contract\ArrayableInterface;
use Anomaly\Streams\Platform\Ui\Table\Button\ButtonCollection;
use Anomaly\Streams\Platform\Ui\Table\Button\Contract\ButtonInterface;
use Anomaly\Streams\Platform\Ui\Table\Column\ColumnCollection;
use Anomaly\Streams\Platform\Ui\Table\Column\Contract\ColumnInterface;
use Anomaly\Streams\Platform\Ui\Table\Row\Contract\RowInterface;

/**
 * Class Row
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Row
 */
class Row implements RowInterface
{

    /**
     * The entry object.
     *
     * @var
     */
    protected $entry;

    /**
     * The columns collection.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Column\ColumnCollection
     */
    protected $columns;

    /**
     * The buttons collection.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Button\ButtonCollection
     */
    protected $buttons;

    /**
     * Create a new Row instance.
     *
     * @param                  $entry
     * @param \Anomaly\Streams\Platform\Ui\Table\Button\ButtonCollection $buttons
     * @param ColumnCollection $columns
     */
    public function __construct($entry, ButtonCollection $buttons, ColumnCollection $columns)
    {
        $this->entry   = $entry;
        $this->buttons = $buttons;
        $this->columns = $columns;
    }

    /**
     * Return the view data.
     *
     * @param  array $arguments
     * @return array
     */
    public function getTableData()
    {
        $entry   = [];
        $buttons = [];
        $columns = [];

        if ($this->entry instanceof ArrayableInterface) {
            $entry = $this->entry->toArray();
        }

        foreach ($this->buttons as $button) {
            if ($button instanceof ButtonInterface) {
                $buttons[] = $button->getTableData();
            }
        }

        foreach ($this->columns as $column) {
            if ($column instanceof ColumnInterface) {
                $column->setEntry($this->entry);

                $columns[] = $column->getTableData();
            }
        }

        return compact('buttons', 'columns', 'entry');
    }
}

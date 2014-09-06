<?php namespace Streams\Core\Ui\Component;

use Streams\Core\Ui\TableUi;

class TableRow
{
    /**
     * The table UI object.
     *
     * @var \Streams\Core\Ui\TableUi
     */
    protected $ui;

    /**
     * Create a new Table instance.
     *
     * @param TableUi $ui
     */
    public function __construct(TableUi $ui)
    {
        $this->ui = $ui;

        $this->column = $this->ui->newColumn($ui);
        $this->button = $this->ui->newButton($ui);
    }

    /**
     * Make the row array.
     *
     * @param $entry
     * @return array
     */
    public function make($entry)
    {
        $columns = $this->makeColumns($entry);
        $buttons = $this->makeButtons($entry);

        return compact('columns', 'buttons');
    }

    /**
     * Return the columns array.
     *
     * @param $entry
     * @return string
     */
    protected function makeColumns($entry)
    {
        $columns = $this->ui->getColumns();

        foreach ($columns as &$column) {
            $column = $this->column->make($entry, $column);
        }

        return $columns;
    }

    /**
     * Return the buttons array.
     *
     * @param $entry
     * @return string
     */
    protected function makeButtons($entry)
    {
        $buttons = $this->ui->getButtons();

        foreach ($buttons as &$button) {
            $button = $this->button->make($entry, $button);
        }

        return $buttons;
    }
}

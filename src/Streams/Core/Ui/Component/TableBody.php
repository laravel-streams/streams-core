<?php namespace Streams\Core\Ui\Component;

use Streams\Core\Ui\TableUi;

class TableBody extends TableComponent
{
    /**
     * The view to use.
     *
     * @var string
     */
    protected $view = null;

    /**
     * Create a new TableBody instance.
     *
     * @param TableUi $ui
     */
    public function __construct(TableUi $ui = null)
    {
        $this->ui = $ui;

        $this->tableRow = $ui->newTableRow();
    }

    /**
     * Return the output.
     *
     * @return string|void
     */
    public function render()
    {
        $rows = $this->buildRows();

        return \View::make($this->view ?: 'streams/partials/table/body', compact('rows'));
    }

    /**
     * Return a collection of TableRow components.
     *
     * @return \Streams\Ui\Collection\TableRowCollection
     */
    protected function buildRows()
    {
        $rows = [];

        foreach ($this->ui->getEntries() as $entry) {

            $row = clone($this->tableRow);

            $row->setEntry($entry);

            $rows[] = compact('row');
        }

        return $this->ui->newTableRowCollection($rows);
    }
}

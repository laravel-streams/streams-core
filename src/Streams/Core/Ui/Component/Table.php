<?php namespace Streams\Core\Ui\Component;

class Table extends TableComponent
{
    /**
     * The table view to use.
     *
     * @var string
     */
    protected $view = 'streams/table';

    /**
     * Render the table.
     *
     * @return string
     */
    public function render()
    {
        $head = $this->ui->newTableHead();
        $body = $this->ui->newTableBody();
        $foot = $this->ui->newTableFoot();

        return \View::make($this->view, compact('head', 'body', 'foot'));
    }
}

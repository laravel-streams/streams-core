<?php namespace Streams\Core\Ui\Component;

class TableFoot extends TableComponent
{
    /**
     * The view to use.
     *
     * @var string
     */
    protected $view = 'streams/partials/table/foot';

    /**
     * Return the output.
     *
     * @return string|void
     */
    public function render()
    {
        $pagination = $this->ui->newTablePagination();

        return \View::make($this->view, compact('pagination'));
    }
}

<?php namespace Streams\Core\Ui\Component;

class TablePagination extends TableComponent
{
    /**
     * The view to use.
     *
     * @var string
     */
    protected $view = 'streams/partials/table/pagination';

    /**
     * Return the output.
     *
     * @return string|void
     */
    public function render()
    {
        return \View::make($this->view);
    }
}

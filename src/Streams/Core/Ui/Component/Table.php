<?php namespace Streams\Core\Ui\Component;

use Illuminate\Support\Facades\Paginator;
use Streams\Core\Ui\TableUi;

class Table
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

        $this->rowBuilder    = $this->ui->newRowBuilder($ui);
        $this->viewBuilder   = $this->ui->newViewBuilder($ui);
        $this->headerBuilder = $this->ui->newHeaderBuilder($ui);
        $this->actionBuilder = $this->ui->newActionBuilder($ui);
    }

    /**
     * Return the data needed to render the table.
     *
     * @return array
     */
    public function data()
    {
        $rows       = $this->assembleRows();
        $views      = $this->assembleViews();
        $headers    = $this->assembleHeaders();
        $actions    = $this->assembleActions();
        $pagination = $this->makePagination();
        $options    = $this->makeOptions();

        return compact('views', 'headers', 'rows', 'actions', 'options', 'pagination');
    }

    /**
     * Return the view data.
     *
     * @return array
     */
    protected function assembleViews()
    {
        $views = [];

        foreach ($this->ui->getViews() as $options) {
            $views[] = $this->viewBuilder->setOptions($options)->data();
        }

        return $views;
    }

    /**
     * Return the rows data.
     *
     * @return array
     */
    protected function assembleRows()
    {
        $rows = [];

        foreach ($this->ui->getEntries() as $entry) {
            $rows[] = $this->rowBuilder->setEntry($entry)->data();
        }

        return $rows;
    }

    /**
     * Return the headers data.
     *
     * @return array
     */
    protected function assembleHeaders()
    {
        $headers = [];

        foreach ($this->ui->getColumns() as $options) {
            $headers[] = $this->headerBuilder->setOptions($options)->data();
        }

        return $headers;
    }

    /**
     * Return the actions data.
     *
     * @return array
     */
    protected function assembleActions()
    {
        $actions = [];

        foreach ($this->ui->getActions() as $options) {
            $actions[] = $this->actionBuilder->setOptions($options)->data();
        }

        return $actions;
    }

    /**
     * Return the table options array.
     *
     * @return array
     */
    protected function makeOptions()
    {
        return [
            'sortable'   => boolean($this->ui->getSortable()),
            'pagination' => boolean($this->ui->getPagination()),
            'tableClass' => $this->ui->getTableClass(),
        ];
    }

    /**
     * Return the pagination array.
     *
     * @return array
     */
    protected function makePagination()
    {
        /*$paginator = $this->ui->getPaginator();

        $links = $paginator->links();

        $pagination = $paginator->toArray();

        $pagination['links'] = $links;

        return $pagination;*/
    }
}

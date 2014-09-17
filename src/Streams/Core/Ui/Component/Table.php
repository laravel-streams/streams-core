<?php namespace Streams\Core\Ui\Component;

use Streams\Core\Ui\TableUi;
use Illuminate\Support\Facades\Paginator;

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
        $this->filterBuilder = $this->ui->newFilterBuilder($ui);
    }

    /**
     * Return the data needed to render the table.
     *
     * @return array
     */
    public function data()
    {
        $rows    = $this->makeRows();
        $views   = $this->makeViews();
        $headers = $this->makeHeaders();
        $actions = $this->makeActions();

        $pagination = $this->buildPagination();
        $options    = $this->buildOptions();

        return compact('views', 'headers', 'rows', 'actions', 'pagination', 'options');
    }

    /**
     * Return the view data.
     *
     * @return array
     */
    protected function makeViews()
    {
        $views = [];

        foreach ($this->ui->getViews() as $view) {
            $views[] = $this->viewBuilder->setView($view)->data();
        }

        return $views;
    }

    /**
     * Return the rows data.
     *
     * @return array
     */
    protected function makeRows()
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
    protected function makeHeaders()
    {
        $headers = [];

        foreach ($this->ui->getColumns() as $options) {
            $headers[] = $this->headerBuilder->make($options)->data();
        }

        return $headers;
    }

    /**
     * Return the actions data.
     *
     * @return array
     */
    protected function makeActions()
    {
        $actions = [];

        foreach ($this->ui->getActions() as $options) {
            $actions[] = $this->actionBuilder->make($options)->data();
        }

        return $actions;
    }

    /**
     * Return the table options array.
     *
     * @return array
     */
    protected function buildOptions()
    {
        return [
            'tableClass'       => $this->ui->getTableClass(),
            'sortable'         => boolean($this->ui->getSortable()),
            'pagination'       => boolean($this->ui->getPagination()),
            'noResultsMessage' => trans($this->ui->getNoResultsMessage()),
        ];
    }

    /**
     * Return the pagination array.
     *
     * @return array
     */
    protected function buildPagination()
    {
        /*$paginator = $this->ui->getPaginator();

        $links = $paginator->links();

        $pagination = $paginator->toArray();

        $pagination['links'] = $links;

        return $pagination;*/
    }
}

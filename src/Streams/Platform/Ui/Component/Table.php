<?php namespace Streams\Platform\Ui\Component;

use Streams\Platform\Ui\TableUi;
use Illuminate\Support\Facades\Paginator;

class Table
{
    /**
     * The table UI object.
     *
     * @var \Streams\Platform\Ui\TableUi
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
        $filters = $this->makeFilters();

        $pagination = $this->buildPagination();
        $options    = $this->buildOptions();

        return compact('views', 'headers', 'rows', 'actions', 'filters', 'pagination', 'options');
    }

    /**
     * Return the view data.
     *
     * @return array
     */
    protected function makeViews()
    {
        $views = [];

        foreach ($this->ui->views() as $view) {
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
            $headers[] = $this->headerBuilder->setOptions($options)->data();
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
            $actions[] = $this->actionBuilder->setOptions($options)->data();
        }

        return $actions;
    }

    /**
     * Return the filters data.
     *
     * @return array
     */
    protected function makeFilters()
    {
        $filters = [];

        foreach ($this->ui->filters() as $filter) {
            $filters[] = $this->filterBuilder->setFilter($filter)->data();
        }

        return $filters;
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
            'filter_state'     => \Input::has('filter') ? 'active' : null,
        ];
    }

    /**
     * Return the pagination array.
     *
     * @return array
     */
    protected function buildPagination()
    {
        $paginator = $this->ui->getPaginator();

        $links = $paginator->appends($_GET)->links();

        $pagination = $paginator->toArray();

        $pagination['links'] = $links;

        return $pagination;
    }
}

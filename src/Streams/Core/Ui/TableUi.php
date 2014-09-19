<?php namespace Streams\Core\Ui;

use Streams\Core\Ui\Builder\TableFilterBuilder;
use Streams\Core\Ui\Collection\TableFilterCollection;
use Streams\Core\Ui\Component\Table;
use Streams\Core\Ui\Builder\TableRowBuilder;
use Streams\Core\Ui\Builder\TableViewBuilder;
use Streams\Core\Ui\Builder\TableActionBuilder;
use Streams\Core\Ui\Builder\TableButtonBuilder;
use Streams\Core\Ui\Builder\TableColumnBuilder;
use Streams\Core\Ui\Builder\TableHeaderBuilder;
use Streams\Core\Ui\Collection\TableViewCollection;

class TableUi extends UiAbstract
{
    /**
     * What column to order by.
     *
     * @var null
     */
    protected $orderBy = 'id';

    /**
     * The sorting direction.
     *
     * @var string
     */
    protected $sort = 'ASC';

    /**
     * The limit value.
     *
     * @var null
     */
    protected $limit = 15;

    /**
     * The pagination flag.
     *
     * @var bool
     */
    protected $pagination = true;

    /**
     * The sortable flag.
     *
     * @var bool
     */
    protected $sortable = false;

    /**
     * The table class.
     *
     * @var string
     */
    protected $tableClass = 'table table-hover';

    /**
     * The "no results" message.
     *
     * @var string
     */
    protected $noResultsMessage = 'message.no_results';

    /**
     * The row class.
     *
     * @var string
     */
    protected $rowClass = '';

    /**
     * The actions array.
     *
     * @var null
     */
    protected $actions = [];

    /**
     * The views array.
     *
     * @var array
     */
    protected $views = [];

    /**
     * The filters array.
     *
     * @var null
     */
    protected $filters = [];

    /**
     * The columns array.
     *
     * @var null
     */
    protected $columns = [];

    /**
     * The buttons array.
     *
     * @var null
     */
    protected $buttons = [];

    /**
     * The entries collection.
     *
     * @var
     */
    protected $entries = null;

    /**
     * The entry total.
     *
     * @var null
     */
    protected $total = null;

    /**
     * The paginator object.
     *
     * @var null
     */
    protected $paginator = null;

    /**
     * The wrapper view.
     *
     * @var string
     */
    protected $wrapper = 'html/blank';

    /**
     * The table view.
     *
     * @var string
     */
    protected $view = 'html/table';

    /**
     * The table object.
     *
     * @var Component\Table
     */
    protected $table;

    /**
     * The repository object.
     *
     * @var Support\Repository
     */
    protected $repository;

    /**
     * Create a new TableUi instance.
     *
     * @param null $slug
     * @param null $namespace
     */
    public function __construct($model = null)
    {
        if ($model) {
            $this->model = $model;
        }

        $this->table      = $this->newTable($this);
        $this->repository = $this->newRepository($this);

        return $this;
    }

    /**
     * Trigger the formation of the table.
     *
     * @return $this
     */
    protected function trigger()
    {
        if (!$this->entries) {
            $this->entries = $this->repository->get();
        }

        $this->output = \View::make($this->view, $this->table->data());

        return $this;
    }

    /**
     * Return a collection of views.
     *
     * @return TableViewCollection
     */
    public function views()
    {
        return new TableViewCollection($this->views);
    }

    /**
     * Return a collection of filters.
     *
     * @return TableFilterCollection
     */
    public function filters()
    {
        return new TableFilterCollection($this, $this->filters);
    }

    /**
     * Get the order by value.
     *
     * @return null
     */
    public function getOrderBy()
    {
        return $this->orderBy;
    }

    /**
     * Set the order by value.
     *
     * @param $orderBy
     */
    public function setOrderBy($orderBy)
    {
        $this->orderBy = $orderBy;

        return $this;
    }

    /**
     * Get the sort.
     *
     * @return string
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Set the sort.
     *
     * @param $sort
     */
    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * Get the limit.
     *
     * @return null
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * Set the limit.
     *
     * @param $limit
     * @return $this
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * Get the pagination flag.
     *
     * @return bool
     */
    public function getPagination()
    {
        return $this->pagination;
    }

    /**
     * Set the pagination flag.
     *
     * @param $pagination
     * @return $this
     */
    public function setPagination($pagination)
    {
        $this->pagination = $pagination;

        return $this;
    }

    /**
     * Get the entry total.
     *
     * @return null
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Get the sortable flag.
     *
     * @return bool
     */
    public function getSortable()
    {
        return $this->sortable;
    }

    /**
     * Set the sortable flag.
     *
     * @param boolean $sortable
     */
    public function setSortable($sortable)
    {
        $this->sortable = $sortable;

        return $this;
    }

    /**
     * Get the table class.
     *
     * @return string
     */
    public function getTableClass()
    {
        return $this->tableClass;
    }

    /**
     * Set the table class.
     *
     * @param boolean $class
     */
    public function setTableClass($class)
    {
        $this->tableClass = $class;

        return $this;
    }

    /**
     * Get the no results message.
     *
     * @return string
     */
    public function getNoResultsMessage()
    {
        return $this->noResultsMessage;
    }

    /**
     * The the no results message.
     *
     * @param $message
     */
    protected function setNoResultsMessage($message)
    {
        $this->noResultsMessage = $message;
    }

    /**
     * Get the row class.
     *
     * @return string
     */
    public function getRowClass()
    {
        return $this->rowClass;
    }

    /**
     * Set the row class.
     *
     * @param boolean $class
     */
    public function setRowClass($class)
    {
        $this->rowClass = $class;

        return $this;
    }

    /**
     * Get the actions.
     *
     * @return null
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * Set the actions.
     *
     * @param $actions
     * @return $this
     */
    public function setActions($actions)
    {
        $this->actions = $actions;

        return $this;
    }

    /**
     * Add an action.
     *
     * @param $action
     * @return $this
     */
    public function addAction($action)
    {
        $this->actions[] = $action;

        return $this;
    }

    /**
     * Get the views.
     *
     * @return array
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * Set the views.
     *
     * @param $views
     * @return $this
     */
    public function setViews($views)
    {
        $this->views = $views;

        return $this;
    }

    /**
     * Add a view.
     *
     * @param $view
     * @return $this
     */
    public function addView($view)
    {
        $this->views[] = $view;

        return $this;
    }

    /**
     * Get the filters.
     *
     * @return null
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * Set the filters.
     *
     * @param $filters
     */
    public function setFilters($filters)
    {
        $this->filters = $filters;

        return $this;
    }

    /**
     * Add a filter.
     *
     * @param $filter
     * @return $this
     */
    public function addFilter($filter)
    {
        $this->filters[] = $filter;

        return $this;
    }

    /**
     * Return the columns.
     *
     * @return null
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * Set the columns.
     *
     * @param $columns
     * @return $this
     */
    public function setColumns($columns)
    {
        $this->columns = $columns;

        return $this;
    }

    /**
     * Add a column.
     *
     * @param $column
     * @return $this
     */
    public function addColumn($column)
    {
        $this->columns[] = $column;

        return $this;
    }

    /**
     * Return the buttons.
     *
     * @return null
     */
    public function getButtons()
    {
        return $this->buttons;
    }

    /**
     * Set the buttons.
     *
     * @param $buttons
     * @return $this
     */
    public function setButtons($buttons)
    {
        $this->buttons = $buttons;

        return $this;
    }

    /**
     * Add a button.
     *
     * @param $button
     * @return $this
     */
    public function addButton($button)
    {
        $this->buttons[] = $button;

        return $this;
    }

    /**
     * Return the entries.
     *
     * @return null
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /**
     * Set the entries.
     *
     * @param null $entries
     */
    public function setEntries($entries)
    {
        $this->entries = $entries;

        return $this;
    }

    /**
     * Add an entry.
     *
     * @param $entry
     * @return $this
     */
    public function addEntry($entry)
    {
        $this->entries[] = $entry;

        return $this;
    }

    /**
     * Set the table view.
     *
     * @param $view
     * @return $this
     */
    public function setView($view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * Return a new Table instance.
     *
     * @param $ui
     * @return Table
     */
    protected function newTable($ui)
    {
        return new Table($ui);
    }

    /**
     * Return a new paginator instance.
     *
     * @return mixed
     */
    protected function newPaginator()
    {
        return \App::make('paginator');
    }

    /**
     * Return a new TableViewBuilder instance.
     *
     * @param $ui
     * @return TableViewBuilder
     */
    public function newViewBuilder($ui)
    {
        return new TableViewBuilder($ui);
    }

    /**
     * Return a new TableHeaderBuilder instance.
     *
     * @param $ui
     * @return TableHeaderBuilder
     */
    public function newHeaderBuilder($ui)
    {
        return new TableHeaderBuilder($ui);
    }

    /**
     * Return a new TableActionBuilder instance.
     *
     * @param $ui
     * @return TableActionBuilder
     */
    public function newActionBuilder($ui)
    {
        return new TableActionBuilder($ui);
    }

    /**
     * Return a new TableRowBuilder instance.
     *
     * @param $ui
     * @return TableRowBuilder
     */
    public function newRowBuilder($ui)
    {
        return new TableRowBuilder($ui);
    }

    /**
     * Return a new TableColumnBuilder instance.
     *
     * @param $ui
     * @return TableColumnBuilder
     */
    public function newColumnBuilder($ui)
    {
        return new TableColumnBuilder($ui);
    }

    /**
     * Return a new TableButtonBuilder instance.
     *
     * @param $ui
     * @return TableButtonBuilder
     */
    public function newButtonBuilder($ui)
    {
        return new TableButtonBuilder($ui);
    }

    /**
     * Return a new TableFilterBuilder instance.
     *
     * @param $ui
     * @return TableFilterBuilder
     */
    public function newFilterBuilder($ui)
    {
        return new TableFilterBuilder($ui);
    }
}

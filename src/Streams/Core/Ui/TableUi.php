<?php namespace Streams\Core\Ui;

use Streams\Core\Ui\Component\Table;
use Streams\Core\Ui\Component\TableAction;
use Streams\Core\Ui\Component\TableButton;
use Streams\Core\Ui\Component\TableColumn;
use Streams\Core\Ui\Component\TableHeader;
use Streams\Core\Ui\Component\TableRow;
use Streams\Core\Ui\Component\TableView;
use Streams\Core\Ui\Entry\EntryRepository;

class TableUi extends UiAbstract
{
    /**
     * The model we are working with.
     *
     * @var null
     */
    protected $model = null;

    /**
     * The active query object.
     *
     * @var null
     */
    protected $query = null;

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
     * Limit results.
     *
     * @var null
     */
    protected $limit = null;

    /**
     * The pagination value.
     *
     * @var null
     */
    protected $paginate = null;

    /**
     * The total number of entries.
     *
     * @var null
     */
    protected $total = null;

    /**
     * Are rows sortable?
     *
     * @var bool
     */
    protected $sortable = false;

    /**
     * Mass assignable actions.
     *
     * @var null
     */
    protected $actions = [];

    /**
     * Views for the table.
     *
     * @var array
     */
    protected $views = [];

    /**
     * Filters for the table.
     *
     * @var null
     */
    protected $filters = [];

    /**
     * Column to for the table.
     *
     * @var null
     */
    protected $columns = [];

    /**
     * Button template for each row.
     *
     * @var null
     */
    protected $buttons = [];

    /**
     * The entries to render in the table.
     *
     * @var null
     */
    protected $entries = [];

    /**
     * The table object.
     *
     * @var Component\Table
     */
    protected $table;

    /**
     * The repository object.
     *
     * @var Entry\EntryRepository
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
        $this->repository = $this->newEntryRepository($this);
        $this->table      = $this->newTable($this);

        if ($model) {
            return $this->make($model);
        }

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

        $this->output = \View::make('html/table', $this->table->make());

        return $this;
    }

    /**
     * Return the model object.
     *
     * @return null
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set the column to order by.
     *
     * @param null $orderBy
     */
    public function setOrderBy($orderBy)
    {
        $this->orderBy = $orderBy;

        return $this;
    }

    /**
     * Set the sort order.
     *
     * @param null $sort
     */
    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * Set the query limit.
     *
     * @param null $limit
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * Set the paginate value.
     *
     * @param null $paginate
     */
    public function setPaginate($paginate)
    {
        $this->paginate = $paginate;

        return $this;
    }

    /**
     * Get the total count.
     *
     * @return null
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set the total count.
     *
     * @param null $total
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
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
     * @param array $actions
     * @return $this
     */
    public function setActions(array $actions)
    {
        foreach ($actions as $action) {
            $this->addAction($action);
        }

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
     * Get the views array.
     *
     * @return array
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * Set the views array.
     *
     * @param $views
     * @return $this
     */
    public function setViews($views)
    {
        foreach ($views as $view) {
            $this->addView($view);
        }

        return $this;
    }

    /**
     * Add a view to the array.
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
     * Get the filters array.
     *
     * @return null
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * Set the filters array.
     *
     * @param $filters
     */
    public function setFilters($filters)
    {
        foreach ($filters as $filter) {
            $this->addFilter($filter);
        }

        return $this;
    }

    /**
     * Add a filter to the filters array.
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
     * Return the columns configuration.
     *
     * @return null
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * Set the column configurations.
     *
     * @param array $columns
     * @return $this
     */
    public function setColumns(array $columns)
    {
        foreach ($columns as $column) {
            $this->addColumn($column);
        }

        return $this;
    }

    /**
     * Add a column configuration.
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
     * Return the buttons array.
     *
     * @return null
     */
    public function getButtons()
    {
        return $this->buttons;
    }

    /**
     * Set the button configuration.
     *
     * @param $buttons
     * @return $this
     */
    public function setButtons($buttons)
    {
        foreach ($buttons as $button) {
            $this->addButton($button);
        }

        return $this;
    }

    /**
     * Add a button configuration.
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
     * Return the entries collection.
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
        foreach ($entries as $entry) {
            $this->addEntry($entry);
        }

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
     * Return a new Table instance.
     *
     * @param $ui
     * @return Table
     */
    public function newTable($ui)
    {
        return new Table($ui);
    }

    /**
     * Return a new entry repository instance.
     *
     * @param $ui
     * @return EntryRepository
     */
    public function newEntryRepository($ui)
    {
        return new EntryRepository($ui);
    }
}

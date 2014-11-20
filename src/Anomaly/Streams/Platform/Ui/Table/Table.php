<?php namespace Anomaly\Streams\Platform\Ui\Table;

use Anomaly\Streams\Platform\Ui\Table\Command\HandleTableActionCommand;
use Anomaly\Streams\Platform\Ui\Table\Event\BootedEvent;
use Anomaly\Streams\Platform\Ui\Table\Event\MadeEvent;
use Anomaly\Streams\Platform\Ui\Table\Event\TriggeredEvent;
use Anomaly\Streams\Platform\Ui\Table\Event\TriggeringEvent;
use Anomaly\Streams\Platform\Ui\Ui;
use Illuminate\Pagination\Paginator;

/**
 * Class Table
 *
 * This class is responsible for rendering entry
 * tables and handling their primary features.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table
 */
class Table extends Ui
{

    /**
     * Eager loaded relationships.
     *
     * @var array
     */
    protected $eager = [];

    /**
     * Ordering config.
     *
     * @var array
     */
    protected $orderBy = [
        'id' => 'asc',
    ];

    /**
     * The query limit.
     *
     * @var null
     */
    protected $limit = null;

    /**
     * The paginate flag. If false
     * pagination will be skipped.
     *
     * @var bool
     */
    protected $paginate = true;

    /**
     * The sortable flag. If true
     * enable custom draggable sorting.
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
     * The row class.
     *
     * @var null
     */
    protected $rowClass = null;

    /**
     * The message displayed when
     * no results are found.
     *
     * @var string
     */
    protected $noResultsMessage = 'message.error.no_results';

    /**
     * The table entries. These can be
     * set manually to bypass the repository.
     *
     * @var null
     */
    protected $entries = null;

    /**
     * The query object.
     *
     * @var null
     */
    protected $query = null;

    /**
     * Table views. These allow you to override
     * the query and configuration of the table
     * during runtime operation.
     *
     * @var array
     */
    protected $views = [];

    /**
     * Table filters. These allow you to
     * filter the table results.
     *
     * @var array
     */
    protected $filters = [];

    /**
     * Table columns. This is a simple
     * config for table columns.
     *
     * @var array
     */
    protected $columns = [];

    /**
     * Column buttons. These are a simple
     * config for buttons rendered on
     * each table column.
     *
     * @var array
     */
    protected $buttons = [];

    /**
     * Table actions. These allow users to
     * apply mass actions to selected entries
     * in the table.
     *
     * @var array
     */
    protected $actions = [];

    /**
     * The table view.
     *
     * @var string
     */
    protected $view = 'ui/table/index';

    /**
     * The table paginator object. This
     * is used internally.
     *
     * @var null
     */
    protected $paginator = null;

    /**
     * The model object used by the table.
     *
     * @var
     */
    protected $model = null;

    /**
     * The table builder object.
     *
     * @var TableBuilder
     */
    protected $builder;

    /**
     * The table presets object.
     *
     * @var TablePresets
     */
    protected $presets;

    /**
     * The table repository object.
     *
     * @var TableRepository
     */
    protected $repository;

    /**
     * Setup the class.
     */
    protected function boot()
    {
        $this->builder    = $this->newBuilder();
        $this->presets    = $this->newPresets();
        $this->repository = $repository = $this->newRepository();

        $this->dispatch(new BootedEvent($this));
    }

    /**
     * Make the table response.
     *
     * @return \Illuminate\View\View|mixed|null
     */
    public function make()
    {
        $this->dispatch(new MadeEvent($this));

        if (!$this->response and app('request')->isMethod('post')) {

            $this->execute(new HandleTableActionCommand($this));
        }

        if (!$this->response) {

            $this->setResponse(parent::make());
        }

        $this->dispatch(new MadeEvent($this));

        return $this->response;
    }


    /**
     * Trigger the response.
     *
     * @return null|string
     */
    protected function trigger()
    {
        $this->dispatch(new TriggeringEvent($this));

        if ($this->entries == null) {

            $this->entries = $this->repository->get();
        }

        $rows       = $this->builder->rows();
        $views      = $this->builder->views();
        $filters    = $this->builder->filters();
        $headers    = $this->builder->headers();
        $actions    = $this->builder->actions();
        $options    = $this->builder->options();
        $pagination = $this->builder->pagination();

        $this->setData(compact('views', 'filters', 'headers', 'rows', 'actions', 'pagination', 'options'));

        $this->dispatch(new TriggeredEvent($this));

        return view($this->view, $this->getData())->render();
    }

    /**
     * Set the eager loaded relationships.
     *
     * @param array $relationships
     * return $this
     */
    public function setEager($relationships)
    {
        $this->eager = $relationships;

        return $this;
    }

    /**
     * Add an eager loaded relationship.
     *
     * @param $relationship
     * @return $this
     */
    public function addEager($relationship)
    {
        $this->eager[] = $relationship;

        return $this;
    }

    /**
     * Get the eager loaded relationships.
     *
     * @return array
     */
    public function getEager()
    {
        return $this->eager;
    }

    /**
     * Set the actions configuration.
     *
     * @param array $actions
     * @return $this
     */
    public function setActions(array $actions)
    {
        $this->actions = $actions;

        return $this;
    }

    /**
     * Add an action configuration.
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
     * Get the actions configuration.
     *
     * @return array
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * Set the buttons configuration.
     *
     * @param array $buttons
     * @return $this
     */
    public function setButtons(array $buttons)
    {
        $this->buttons = $buttons;

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
     * Get the buttons configuration.
     *
     * @return array
     */
    public function getButtons()
    {
        return $this->buttons;
    }

    /**
     * Set the columns configuration.
     *
     * @param array $columns
     * @return $this
     */
    public function setColumns(array $columns)
    {
        $this->columns = $columns;

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
     * Get the columns configuration.
     *
     * @return array
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * Set the filters configuration.
     *
     * @param array $filters
     * @return $this
     */
    public function setFilters(array $filters)
    {
        $this->filters = $filters;

        return $this;
    }

    /**
     * Add a filter configuration.
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
     * Get the filters configuration.
     *
     * @return array
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * Set the table entries.
     *
     * @param array $entries
     * @return $this
     */
    public function setEntries(array $entries)
    {
        $this->entries = $entries;

        return $this;
    }

    /**
     * Add an entry to the table.
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
     * Get the table entries.
     *
     * @return null
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /**
     * Set the limit.
     *
     * @param null $limit
     * return $this
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * Get the limit.
     *
     * @return null
     */
    public function getLimit()
    {
        if (!$this->limit) {

            $this->limit = setting('module.settings::results_per_page', 15);
        }

        return $this->limit;
    }

    /**
     * Set the no results message.
     *
     * @param string $noResultsMessage
     * return $this
     */
    public function setNoResultsMessage($message)
    {
        $this->noResultsMessage = $message;

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
     * Set the order by configuration.
     *
     * @param $orderBy
     * @return $this
     */
    public function setOrderBy($orderBy)
    {
        $this->orderBy = $orderBy;

        return $this;
    }

    /**
     * Add an order by configuration.
     *
     * @param $column
     * @param $direction
     * @return $this
     */
    public function addOrderBy($column, $direction)
    {
        $this->orderBy[$column] = $direction;

        return $this;
    }

    /**
     * Get the order by configuration.
     *
     * @return array
     */
    public function getOrderBy()
    {
        return $this->orderBy;
    }

    /**
     * Set the paginate flag.
     *
     * @param $paginate
     * @return $this
     */
    public function setPaginate($paginate)
    {
        $this->paginate = $paginate;

        return $this;
    }

    /**
     * Get the paginate flag.
     *
     * @return boolean
     */
    public function getPaginate()
    {
        return $this->paginate;
    }

    /**
     * Set the sortable flag.
     *
     * @param boolean $sortable
     * return $this
     */
    public function setSortable($sortable)
    {
        $this->sortable = $sortable;

        return $this;
    }

    /**
     * get the sortable flag.
     *
     * @return boolean
     */
    public function getSortable()
    {
        return $this->sortable;
    }

    /**
     * Set the row class.
     *
     * @param null $rowClass
     * return $this
     */
    public function setRowClass($rowClass)
    {
        $this->rowClass = $rowClass;

        return $this;
    }

    /**
     * Get the row class.
     *
     * @return null
     */
    public function getRowClass()
    {
        return $this->rowClass;
    }

    /**
     * Set the table class.
     *
     * @param string $tableClass
     * return $this
     */
    public function setTableClass($tableClass)
    {
        $this->tableClass = $tableClass;

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
     * Set the table view.
     *
     * @param string $view
     * return $this
     */
    public function setView($view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * Set the views configuration.
     *
     * @param array $views
     * @return $this
     */
    public function setViews(array $views)
    {
        $this->views = $views;

        return $this;
    }

    /**
     * Add a view configuration.
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
     * Get the views configuration.
     *
     * @return array
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * Set the wrapper view.
     *
     * @param string $wrapper
     * return $this
     */
    public function setWrapperView($wrapper)
    {
        $this->wrapperView = $wrapper;

        return $this;
    }

    /**
     * Set the paginator object.
     *
     * @param null $paginator
     * return $this
     */
    public function setPaginator(Paginator $paginator)
    {
        $this->paginator = $paginator;

        return $this;
    }

    /**
     * Get the paginator object.
     *
     * @return Paginator
     */
    public function getPaginator()
    {
        return $this->paginator;
    }

    /**
     * Set the query.
     *
     * @param null $query
     * return $this
     */
    public function setQuery($query)
    {
        $this->query = $query;

        return $this;
    }

    /**
     * Get the query.
     *
     * @return null
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Return a new builder instance.
     *
     * @return TableBuilder
     */
    protected function newBuilder()
    {
        if (!$builder = $this->transform(__METHOD__)) {

            $builder = 'Anomaly\Streams\Platform\Ui\Table\TableBuilder';
        }

        return app()->make($builder, [$this]);
    }

    /**
     * Return a new presets instance.
     *
     * @return TablePresets
     */
    protected function newPresets()
    {
        if (!$presets = $this->transform(__METHOD__)) {

            $presets = 'Anomaly\Streams\Platform\Ui\Table\TablePresets';
        }

        return app()->make($presets, [$this]);
    }

    /**
     * Return a new repository instance.
     *
     * @return TableRepository
     */
    protected function newRepository()
    {
        if (!$repository = $this->transform(__FUNCTION__)) {

            $repository = 'Anomaly\Streams\Platform\Ui\Table\TableRepository';
        }

        return app()->make($repository, [$this]);
    }
}

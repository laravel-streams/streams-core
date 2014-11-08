<?php namespace Anomaly\Streams\Platform\Ui\Table;

use Anomaly\Streams\Platform\Contract\PaginatorInterface;
use Anomaly\Streams\Platform\Ui\Table\Command\HandleTableActionCommand;
use Anomaly\Streams\Platform\Ui\Table\Command\HandleTableFiltersCommand;
use Anomaly\Streams\Platform\Ui\Table\Command\HandleTableViewCommand;
use Anomaly\Streams\Platform\Ui\Ui;
use Symfony\Component\HttpFoundation\Response;

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
     * @var array
     */
    protected $orderBy = [
        'id' => 'asc',
    ];

    /**
     * @var null
     */
    protected $limit = null;

    /**
     * @var bool
     */
    protected $paginate = true;

    /**
     * @var bool
     */
    protected $sortable = false;

    /**
     * @var string
     */
    protected $tableClass = 'table table-hover';

    /**
     * @var null
     */
    protected $rowClass = null;

    /**
     * @var string
     */
    protected $noResultsMessage = 'error.no_results';

    /**
     * @var null
     */
    protected $entries = null;

    /**
     * @var array
     */
    protected $views = [];

    /**
     * @var array
     */
    protected $filters = [];

    /**
     * @var array
     */
    protected $columns = [];

    /**
     * @var array
     */
    protected $buttons = [];

    /**
     * @var array
     */
    protected $actions = [];

    /**
     * @var string
     */
    protected $view = 'ui/table/index';

    /**
     * @var null
     */
    protected $paginator = null;

    /**
     * @var
     */
    protected $model = null;

    protected $builder;

    protected $repository;

    /**
     * Create a new Table instance.
     */
    public function __construct()
    {
        $this->builder    = $this->newBuilder();
        $this->repository = $repository = $this->newRepository();

        parent::__construct();
    }

    /**
     * Make the table response.
     *
     * @return \Illuminate\View\View|mixed|null
     */
    public function make()
    {
        return $this->fire('make');
    }


    /**
     * Trigger the response.
     *
     * @return null|string
     */
    protected function trigger()
    {
        $this->fire('trigger');

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

        $data = compact('views', 'filters', 'headers', 'rows', 'actions', 'pagination', 'options');

        return view($this->view, $data)->render();
    }

    /**
     * @param array $eager
     * return $this
     */
    public function setEager($eager)
    {
        $this->eager = $eager;

        return $this;
    }

    /**
     * @return array
     */
    public function getEager()
    {
        return $this->eager;
    }

    /**
     * @param array $actions
     * @return $this
     */
    public function setActions(array $actions)
    {
        $this->actions = $actions;

        return $this;
    }

    /**
     * @return array
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * @param array $buttons
     * @return $this
     */
    public function setButtons(array $buttons)
    {
        $this->buttons = $buttons;

        return $this;
    }

    /**
     * @return array
     */
    public function getButtons()
    {
        return $this->buttons;
    }

    /**
     * @param array $columns
     * @return $this
     */
    public function setColumns(array $columns)
    {
        $this->columns = $columns;

        return $this;
    }

    /**
     * @return array
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * @param array $entries
     * @return $this
     */
    public function setEntries(array $entries)
    {
        $this->entries = $entries;

        return $this;
    }

    /**
     * @return null
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /**
     * @param array $filters
     * @return $this
     */
    public function setFilters(array $filters)
    {
        $this->filters = $filters;

        return $this;
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * @param null $limit
     * return $this
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
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
     * @param string $noResultsMessage
     * return $this
     */
    public function setNoResultsMessage($noResultsMessage)
    {
        $this->noResultsMessage = $noResultsMessage;

        return $this;
    }

    /**
     * @return string
     */
    public function getNoResultsMessage()
    {
        return $this->noResultsMessage;
    }

    /**
     * @param $column
     * @param $direction
     * @return $this
     */
    public function setOrderBy($column, $direction)
    {
        $this->orderBy = [
            'column'    => $column,
            'direction' => $direction,
        ];

        return $this;
    }

    /**
     * @return array
     */
    public function getOrderBy()
    {
        return $this->orderBy;
    }

    /**
     * @param $paginate
     * @return $this
     */
    public function setPaginate($paginate)
    {
        $this->paginate = $paginate;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getPaginate()
    {
        return $this->paginate;
    }

    /**
     * @param null $rowClass
     * return $this
     */
    public function setRowClass($rowClass)
    {
        $this->rowClass = $rowClass;

        return $this;
    }

    /**
     * @return null
     */
    public function getRowClass()
    {
        return $this->rowClass;
    }

    /**
     * @param boolean $sortable
     * return $this
     */
    public function setSortable($sortable)
    {
        $this->sortable = $sortable;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getSortable()
    {
        return $this->sortable;
    }

    /**
     * @param string $tableClass
     * return $this
     */
    public function setTableClass($tableClass)
    {
        $this->tableClass = $tableClass;

        return $this;
    }

    /**
     * @return string
     */
    public function getTableClass()
    {
        return $this->tableClass;
    }

    /**
     * @param string $view
     * return $this
     */
    public function setView($view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * @param array $views
     * @return $this
     */
    public function setViews(array $views)
    {
        $this->views = $views;

        return $this;
    }

    /**
     * @return array
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * @param string $wrapper
     * return $this
     */
    public function setWrapper($wrapper)
    {
        $this->wrapper = $wrapper;

        return $this;
    }

    /**
     * @param null $paginator
     * return $this
     */
    public function setPaginator(PaginatorInterface $paginator)
    {
        $this->paginator = $paginator;

        return $this;
    }

    /**
     * @return null
     */
    public function getPaginator()
    {
        return $this->paginator;
    }

    protected function newRepository()
    {
        if (!$repository = $this->transform(__FUNCTION__)) {

            $repository = 'Anomaly\Streams\Platform\Ui\Table\TableRepository';
        }

        return app()->make($repository, ['table' => $this]);
    }

    protected function newBuilder()
    {
        if (!$builder = $this->transform(__METHOD__)) {

            $builder = 'Anomaly\Streams\Platform\Ui\Table\TableBuilder';
        }

        return app()->make($builder, ['table' => $this]);
    }

    /**
     * Fire when making the response.
     *
     * @param $data
     */
    protected function onMake()
    {
        if (!$this->response and app('request')->isMethod('post')) {

            // TODO: This should set the response internally.
            return $this->execute(new HandleTableActionCommand($this));
        }

        if (!$this->response) {

            $this->setResponse(parent::make());
        }

        return $this->response;
    }

    /**
     * Fire just before querying.
     *
     * @param $query
     * @return mixed
     */
    protected function onQuery(&$query)
    {
        // TODO: Move this stuff to an event?
        $query = $this->execute(new HandleTableViewCommand($this, $query));
        $query = $this->execute(new HandleTableFiltersCommand($this, $query));
    }
}

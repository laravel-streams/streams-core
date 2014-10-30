<?php namespace Anomaly\Streams\Platform\Ui\Table;

use Anomaly\Streams\Platform\Contract\PaginatorInterface;
use Anomaly\Streams\Platform\Ui\Table\Command\HandleTableActionCommand;
use Anomaly\Streams\Platform\Ui\Table\Command\HandleTableFiltersCommand;
use Anomaly\Streams\Platform\Ui\Table\Command\HandleTableViewCommand;
use Anomaly\Streams\Platform\Ui\Ui;

/**
 * Class TableUi
 *
 * This class is responsible for rendering entry
 * tables and handling their primary features.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table
 */
class TableUi extends Ui
{

    /**
     * @var array
     */
    protected $orderBy = [
        'column'    => 'id',
        'direction' => 'asc',
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
    protected $noResultsMessage = 'streams::message.no_results';

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
    protected $view = 'html/table';

    /**
     * @var null
     */
    protected $paginator = null;

    /**
     * @var
     */
    protected $model;

    /**
     * Trigger logic to build content.
     *
     * @return null|string
     */
    protected function trigger()
    {
        $this->fire('trigger');

        $repository = $this->newRepository();

        if (!$this->entries) {
            $this->entries = $repository->get();
        }

        $table = $this->newTable();

        $rows       = $table->rows();
        $views      = $table->views();
        $filters    = $table->filters();
        $headers    = $table->headers();
        $actions    = $table->actions();
        $options    = $table->options();
        $pagination = $table->pagination();

        $data = compact('views', 'filters', 'headers', 'rows', 'actions', 'pagination', 'options');

        $this->fire('rendering', [$data]);

        return view($this->view, $data)->render();
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

            $this->limit = 2;
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

    /**
     * @return TableRepository
     */
    private function newRepository()
    {
        return new TableRepository($this, $this->model);
    }

    /**
     * @return TableService
     */
    protected function newTable()
    {
        return new TableService($this);
    }

    /**
     * Fire just before rendering table view.
     *
     * @param $data
     */
    protected function onRendering($data)
    {
        //
    }

    /**
     * Fire just before responding with a view.
     *
     * @return mixed
     */
    protected function onResponse()
    {
        return $this->execute(new HandleTableActionCommand($this));
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

<?php namespace Anomaly\Streams\Platform\Ui\Table;

use Anomaly\Streams\Platform\Ui\Ui;

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
     * @var
     */
    protected $model;

    /**
     * @return $this|void
     */
    public function build()
    {
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

        $this->fire('render');

        return view($this->view, $data)->render();
    }

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
}

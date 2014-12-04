<?php namespace Anomaly\Streams\Platform\Ui\Table;

use Anomaly\Streams\Platform\Ui\Button\ButtonCollection;
use Anomaly\Streams\Platform\Ui\Table\Action\ActionCollection;
use Anomaly\Streams\Platform\Ui\Table\Column\ColumnCollection;
use Anomaly\Streams\Platform\Ui\Table\Filter\FilterCollection;
use Anomaly\Streams\Platform\Ui\Table\Row\RowCollection;
use Anomaly\Streams\Platform\Ui\Table\View\ViewCollection;
use Illuminate\Support\Collection;
use Laracasts\Commander\Events\DispatchableTrait;
use Laracasts\Commander\Events\EventGenerator;

class Table
{

    use EventGenerator;
    use DispatchableTrait;

    protected $prefix = null;

    protected $sortable = true;

    protected $eager = [];

    protected $limit = null;

    protected $orderBy = ['id' => 'asc'];

    protected $view = 'ui/table/index';

    protected $wrapper = 'wrappers/blank';

    protected $data = [];

    protected $stream = null;

    protected $content = null;

    protected $response = null;

    protected $total = 0;

    protected $rows;

    protected $views;

    protected $filters;

    protected $entries;

    protected $columns;

    protected $buttons;

    protected $actions;

    function __construct(
        Collection $entries,
        RowCollection $rows,
        ViewCollection $views,
        ActionCollection $actions,
        ButtonCollection $buttons,
        ColumnCollection $columns,
        FilterCollection $filters
    ) {
        $this->rows    = $rows;
        $this->views   = $views;
        $this->entries = $entries;
        $this->actions = $actions;
        $this->buttons = $buttons;
        $this->columns = $columns;
        $this->filters = $filters;
    }

    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    public function getPrefix()
    {
        return $this->prefix;
    }

    public function setView($view)
    {
        $this->view = $view;

        return $this;
    }

    public function getView()
    {
        return $this->view;
    }

    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    public function putData($key, $data)
    {
        $this->data[$key] = $data;

        return $this;
    }

    public function pullData($key, $default = null)
    {
        return array_get($this->data, $key, $default);
    }

    public function setStream($stream)
    {
        $this->stream = $stream;

        return $this;
    }

    public function getStream()
    {
        return $this->stream;
    }

    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function setWrapper($wrapper)
    {
        $this->wrapper = $wrapper;

        return $this;
    }

    public function getWrapper()
    {
        return $this->wrapper;
    }

    public function setSortable($sortable)
    {
        $this->sortable = $sortable;

        return $this;
    }

    public function isSortable()
    {
        return $this->sortable;
    }

    public function setEager(array $eager)
    {
        $this->eager = $eager;

        return $this;
    }

    public function getEager()
    {
        return $this->eager;
    }

    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    public function getLimit()
    {
        if (!$this->limit) {

            return 15;
        }

        return $this->limit;
    }

    public function setOrderBy($orderBy)
    {
        $this->orderBy = $orderBy;

        return $this;
    }

    public function getOrderBy()
    {
        return $this->orderBy;
    }

    public function getActions()
    {
        return $this->actions;
    }

    public function getButtons()
    {
        return $this->buttons;
    }

    public function getColumns()
    {
        return $this->columns;
    }

    public function getFilters()
    {
        return $this->filters;
    }

    public function getViews()
    {
        return $this->views;
    }

    public function getEntries()
    {
        return $this->entries;
    }

    public function getRows()
    {
        return $this->rows;
    }
}
 
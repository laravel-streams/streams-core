<?php namespace Anomaly\Streams\Platform\Ui\Table;

use Anomaly\Streams\Platform\Ui\Button\ButtonCollection;
use Anomaly\Streams\Platform\Ui\Table\Action\ActionCollection;
use Anomaly\Streams\Platform\Ui\Table\Column\ColumnCollection;
use Anomaly\Streams\Platform\Ui\Table\Filter\FilterCollection;
use Anomaly\Streams\Platform\Ui\Table\Header\HeaderCollection;
use Anomaly\Streams\Platform\Ui\Table\Row\RowCollection;
use Anomaly\Streams\Platform\Ui\Table\View\ViewCollection;
use Illuminate\Support\Collection;

/**
 * Class Table
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table
 */
class Table
{

    /**
     * The table prefix.
     *
     * @var string
     */
    protected $prefix = 'table_';

    /**
     * The sortable flag.
     *
     * @var bool
     */
    protected $sortable = false;

    /**
     * The array of fields to eager load.
     *
     * @var array
     */
    protected $eager = [];

    /**
     * The limit config.
     *
     * @var null
     */
    protected $limit = null;

    /**
     * The ordering config.
     *
     * @var array
     */
    protected $orderBy = ['id' => 'asc'];

    /**
     * The message to display when no
     * results are returned.
     *
     * @var string
     */
    protected $noResultsMessage = 'message.error.no_results';

    /**
     * The table view.
     *
     * @var string
     */
    protected $view = 'streams::ui/table/index';

    /**
     * The table's wrapper view.
     *
     * @var string
     */
    protected $wrapper = 'streams::wrappers/blank';

    /**
     * The table's view data.
     *
     * @var array
     */
    protected $data = [];

    /**
     * The stream object.
     *
     * @var null
     */
    protected $stream = null;

    /**
     * The table's content.
     *
     * @var null
     */
    protected $content = null;

    /**
     * The table's response.
     *
     * @var null
     */
    protected $response = null;

    /**
     * The total entries returned by the table.
     *
     * @var int
     */
    protected $total = 0;

    /**
     * The row collection.
     *
     * @var Row\RowCollection
     */
    protected $rows;

    /**
     * The view collection.
     *
     * @var View\ViewCollection
     */
    protected $views;

    /**
     * The filter collection.
     *
     * @var Filter\FilterCollection
     */
    protected $filters;

    /**
     * The entry collection.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $entries;

    /**
     * The column collection.
     *
     * @var Column\ColumnCollection
     */
    protected $columns;

    /**
     * The button collection.
     *
     * @var \Anomaly\Streams\Platform\Ui\Button\ButtonCollection
     */
    protected $buttons;

    /**
     * The actions collection.
     *
     * @var Action\ActionCollection
     */
    protected $actions;

    /**
     * The header collection.
     *
     * @var Header\HeaderCollection
     */
    protected $headers;

    /**
     * Create a new Table instance.
     *
     * @param Collection       $entries
     * @param RowCollection    $rows
     * @param ViewCollection   $views
     * @param ActionCollection $actions
     * @param ButtonCollection $buttons
     * @param ColumnCollection $columns
     * @param FilterCollection $filters
     * @param HeaderCollection $headers
     */
    public function __construct(
        Collection $entries,
        RowCollection $rows,
        ViewCollection $views,
        ActionCollection $actions,
        ButtonCollection $buttons,
        ColumnCollection $columns,
        FilterCollection $filters,
        HeaderCollection $headers
    ) {
        $this->rows    = $rows;
        $this->views   = $views;
        $this->entries = $entries;
        $this->actions = $actions;
        $this->buttons = $buttons;
        $this->columns = $columns;
        $this->filters = $filters;
        $this->headers = $headers;
    }

    /**
     * Set the prefix.
     *
     * @param $prefix
     * @return $this
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Get the prefix.
     *
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Set the view.
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
     * Get the view.
     *
     * @return string
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * Set the table data.
     *
     * @param $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get the table data.
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Put some table data.
     *
     * @param $key
     * @param $data
     * @return $this
     */
    public function putData($key, $data)
    {
        $this->data[$key] = $data;

        return $this;
    }

    /**
     * Pull some table data.
     *
     * @param      $key
     * @param null $default
     * @return mixed
     */
    public function pullData($key, $default = null)
    {
        return array_get($this->data, $key, $default);
    }

    /**
     * Set the stream object.
     *
     * @param $stream
     * @return $this
     */
    public function setStream($stream)
    {
        $this->stream = $stream;

        return $this;
    }

    /**
     * Get the stream object.
     *
     * @return null
     */
    public function getStream()
    {
        return $this->stream;
    }

    /**
     * Set the content.
     *
     * @param $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the content.
     *
     * @return null
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the response.
     *
     * @param $response
     * @return $this
     */
    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * Get the response.
     *
     * @return null
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Set the total.
     *
     * @param $total
     * @return $this
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get the total.
     *
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set the wrapper.
     *
     * @param $wrapper
     * @return $this
     */
    public function setWrapper($wrapper)
    {
        $this->wrapper = $wrapper;

        return $this;
    }

    /**
     * Get the wrapper.
     *
     * @return string
     */
    public function getWrapper()
    {
        return $this->wrapper;
    }

    /**
     * Set the sortable.
     *
     * @param $sortable
     * @return $this
     */
    public function setSortable($sortable)
    {
        $this->sortable = $sortable;

        return $this;
    }

    /**
     * Return the sortable flag.
     *
     * @return bool
     */
    public function isSortable()
    {
        return $this->sortable;
    }

    /**
     * Set the eager loaded fields.
     *
     * @param array $eager
     * @return $this
     */
    public function setEager(array $eager)
    {
        $this->eager = $eager;

        return $this;
    }

    /**
     * Get the eager fields.
     *
     * @return array
     */
    public function getEager()
    {
        return $this->eager;
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
     * Ge the limit.
     *
     * @return int|null
     */
    public function getLimit()
    {
        if (!$this->limit) {
            return 15;
        }

        return $this->limit;
    }

    /**
     * Set the order by config.
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
     * Get the order by config.
     *
     * @return array
     */
    public function getOrderBy()
    {
        return $this->orderBy;
    }

    /**
     * Set the no results message.
     *
     * @param $noResultsMessage
     * @return $this
     */
    public function setNoResultsMessage($noResultsMessage)
    {
        $this->noResultsMessage = $noResultsMessage;

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
     * Get the actions collection.
     *
     * @return ActionCollection
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * Get the buttons collection.
     *
     * @return ButtonCollection
     */
    public function getButtons()
    {
        return $this->buttons;
    }

    /**
     * Get the columns collection.
     *
     * @return ColumnCollection
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * Get the filter collection.
     *
     * @return FilterCollection
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * Get the header collection.
     *
     * @return HeaderCollection
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Get the view collection.
     *
     * @return ViewCollection
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * Set the entries.
     *
     * @param Collection $entries
     * @return $this
     */
    public function setEntries(Collection $entries)
    {
        $this->entries = $entries;

        return $this;
    }

    /**
     * Get the entries.
     *
     * @return Collection
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /**
     * Get the row collection.
     *
     * @return RowCollection
     */
    public function getRows()
    {
        return $this->rows;
    }
}

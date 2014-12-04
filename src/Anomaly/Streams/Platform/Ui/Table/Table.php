<?php namespace Anomaly\Streams\Platform\Ui\Table;

use Anomaly\Streams\Platform\Ui\Button\ButtonCollection;
use Anomaly\Streams\Platform\Ui\Table\Action\ActionCollection;
use Anomaly\Streams\Platform\Ui\Table\Column\ColumnCollection;
use Anomaly\Streams\Platform\Ui\Table\Filter\FilterCollection;
use Anomaly\Streams\Platform\Ui\Table\View\ViewCollection;
use Illuminate\Support\Collection;
use Laracasts\Commander\Events\EventGenerator;

class Table
{

    use EventGenerator;

    protected $prefix = null;

    protected $view = 'ui/table/index';

    protected $wrapper = 'wrappers/blank';

    protected $data = [];

    protected $content = null;

    protected $views;

    protected $filters;

    protected $entries;

    protected $columns;

    protected $buttons;

    protected $actions;

    function __construct(
        Collection $entries,
        ViewCollection $views,
        ActionCollection $actions,
        ButtonCollection $buttons,
        ColumnCollection $columns,
        FilterCollection $filters
    ) {
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

    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    public function getContent()
    {
        return $this->content;
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
}
 
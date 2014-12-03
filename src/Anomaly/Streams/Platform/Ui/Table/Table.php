<?php namespace Anomaly\Streams\Platform\Ui\Table;

use Anomaly\Streams\Platform\Ui\Button\ButtonCollection;
use Anomaly\Streams\Platform\Ui\Table\Action\ActionCollection;
use Anomaly\Streams\Platform\Ui\Table\Column\ColumnCollection;
use Anomaly\Streams\Platform\Ui\Table\Filter\FilterCollection;
use Anomaly\Streams\Platform\Ui\Table\View\ViewCollection;
use Laracasts\Commander\Events\EventGenerator;

class Table
{

    use EventGenerator;

    protected $prefix;

    protected $views;

    protected $filters;

    protected $columns;

    protected $buttons;

    protected $actions;

    function __construct(
        ActionCollection $actions,
        ButtonCollection $buttons,
        ColumnCollection $columns,
        FilterCollection $filters,
        ViewCollection $views
    ) {
        $this->actions = $actions;
        $this->buttons = $buttons;
        $this->columns = $columns;
        $this->filters = $filters;
        $this->views   = $views;
    }

    public function make()
    {
        //
    }

    public function render()
    {
        //
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
}
 
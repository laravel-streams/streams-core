<?php namespace Anomaly\Streams\Platform\Ui\Table;

use Laracasts\Commander\CommanderTrait;
use Laracasts\Commander\Events\DispatchableTrait;
use Laracasts\Commander\Events\EventGenerator;

class TableBuilder
{
    use CommanderTrait;
    use DispatchableTrait;

    protected $standardizerCommand = 'Anomaly\Streams\Platform\Ui\Table\Command\StandardizeInputCommand';

    protected $buildCommand = 'Anomaly\Streams\Platform\Ui\Table\Command\BuildTableCommand';

    protected $handleCommand = 'Anomaly\Streams\Platform\Ui\Table\Command\HandleTableCommand';

    protected $makeCommand = 'Anomaly\Streams\Platform\Ui\Table\Command\MakeTableCommand';

    protected $model = null;

    protected $views = [];

    protected $filters = [];

    protected $columns = [];

    protected $buttons = [];

    protected $actions = [];

    protected $table;

    public function __construct(Table $table)
    {
        $this->table = $table;
    }

    public function build()
    {
        $this->execute($this->standardizerCommand, ['builder' => $this]);
        $this->execute($this->buildCommand, ['builder' => $this]);

        if (app('request')->isMethod('post')) {
            $this->execute($this->handleCommand, ['builder' => $this]);
        }
    }

    public function make()
    {
        $this->build();

        if ($this->table->getResponse() === null) {
            $this->execute($this->makeCommand, ['builder' => $this]);
        }
    }

    public function render()
    {
        $this->make();

        if ($this->table->getResponse() === null) {
            $content = $this->table->getContent();

            return view($this->table->getWrapper(), compact('content'));
        }

        return $this->table->getResponse();
    }

    public function getTable()
    {
        return $this->table;
    }

    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function setViews(array $views)
    {
        $this->views = $views;

        return $this;
    }

    public function getViews()
    {
        return $this->views;
    }

    public function setFilters(array $filters)
    {
        $this->filters = $filters;

        return $this;
    }

    public function getFilters()
    {
        return $this->filters;
    }

    public function setColumns(array $columns)
    {
        $this->columns = $columns;

        return $this;
    }

    public function getColumns()
    {
        return $this->columns;
    }

    public function setButtons(array $buttons)
    {
        $this->buttons = $buttons;

        return $this;
    }

    public function getButtons()
    {
        return $this->buttons;
    }

    public function setActions($actions)
    {
        $this->actions = $actions;

        return $this;
    }

    public function getActions()
    {
        return $this->actions;
    }
}

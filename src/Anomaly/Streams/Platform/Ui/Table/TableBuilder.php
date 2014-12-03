<?php namespace Anomaly\Streams\Platform\Ui\Table;

use Laracasts\Commander\CommanderTrait;
use Laracasts\Commander\Events\DispatchableTrait;
use Laracasts\Commander\Events\EventGenerator;

class TableBuilder
{

    use CommanderTrait;
    use DispatchableTrait;

    protected $views = [
        'view_all' => [
            'test' => 'foo',
            'view' => 'all',
        ],
    ];

    protected $filters = [
        'general' => 'input',
    ];

    protected $columns = [
        'name' => 'Hello there!'
    ];

    protected $buttons = [
        'edit' => 'Edit my balls'
    ];

    protected $actions = [
        'delete' => [
            'action' => 'delete',
            'text'   => 'Fuck',
        ],
    ];

    protected $table;

    function __construct(Table $table)
    {
        $this->table = $table;
    }

    public function build()
    {
        $this->execute('Anomaly\Streams\Platform\Ui\Table\Command\ParseBuilderInputCommand', ['builder' => $this]);
        $this->execute('Anomaly\Streams\Platform\Ui\Table\Command\BuildTableCommand', ['builder' => $this]);

        $this->dispatchEventsFor($this->table);

        return $this->table;
    }

    public function make()
    {
        $table = $this->build();

        return $table->make();
    }

    public function render()
    {
        $table = $this->build();

        $table->make();

        return $table->render();
    }

    public function getTable()
    {
        return $this->table;
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
 
<?php namespace Anomaly\Streams\Platform\Ui\Table;

use Laracasts\Commander\CommanderTrait;
use Laracasts\Commander\Events\DispatchableTrait;
use Laracasts\Commander\Events\EventGenerator;

/**
 * Class TableBuilder
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table
 */
class TableBuilder
{
    use CommanderTrait;
    use DispatchableTrait;

    /**
     * The standardizer command.
     *
     * @var string
     */
    protected $standardizerCommand = 'Anomaly\Streams\Platform\Ui\Table\Command\StandardizeInputCommand';

    /**
     * The build command.
     *
     * @var string
     */
    protected $buildCommand = 'Anomaly\Streams\Platform\Ui\Table\Command\BuildTableCommand';

    /**
     * The handle command.
     *
     * @var string
     */
    protected $handleCommand = 'Anomaly\Streams\Platform\Ui\Table\Command\HandleTableCommand';

    /**
     * The make command.
     *
     * @var string
     */
    protected $makeCommand = 'Anomaly\Streams\Platform\Ui\Table\Command\MakeTableCommand';

    /**
     * The table model.
     *
     * @var null
     */
    protected $model = null;

    /**
     * The table's view config.
     *
     * @var array
     */
    protected $views = [];

    /**
     * The table's filter config.
     *
     * @var array
     */
    protected $filters = [];

    /**
     * The table's column config.
     *
     * @var array
     */
    protected $columns = [];

    /**
     * The table's button config.
     *
     * @var array
     */
    protected $buttons = [];

    /**
     * The table's actions config.
     *
     * @var array
     */
    protected $actions = [];

    /**
     * The table object.
     *
     * @var Table
     */
    protected $table;

    /**
     * Create a new TableBuilder instance.
     *
     * @param Table $table
     */
    public function __construct(Table $table)
    {
        $this->table = $table;
    }

    /**
     * Build the table.
     */
    public function build()
    {
        $this->execute($this->standardizerCommand, ['builder' => $this]);
        $this->execute($this->buildCommand, ['builder' => $this]);

        if (app('request')->isMethod('post')) {
            $this->execute($this->handleCommand, ['builder' => $this]);
        }
    }

    /**
     * Make the table.
     */
    public function make()
    {
        $this->build();

        if ($this->table->getResponse() === null) {
            $this->execute($this->makeCommand, ['builder' => $this]);
        }
    }

    /**
     * Render the table.
     *
     * @return \Illuminate\View\View|null
     */
    public function render()
    {
        $this->make();

        if ($this->table->getResponse() === null) {
            $content = $this->table->getContent();

            return view($this->table->getWrapper(), compact('content'));
        }

        return $this->table->getResponse();
    }

    /**
     * Get the table object.
     *
     * @return Table
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Set the model.
     *
     * @param $model
     * @return $this
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get the model object.
     *
     * @return null
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set the view config.
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
     * Get the view config.
     *
     * @return array
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * Set the filter config.
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
     * Get the filter config.
     *
     * @return array
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * Set the column config.
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
     * Get the column config.
     *
     * @return array
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * Set the button config.
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
     * Get the button config.
     *
     * @return array
     */
    public function getButtons()
    {
        return $this->buttons;
    }

    /**
     * Set actions config.
     *
     * @param $actions
     * @return $this
     */
    public function setActions($actions)
    {
        $this->actions = $actions;

        return $this;
    }

    /**
     * Get the actions config.
     *
     * @return array
     */
    public function getActions()
    {
        return $this->actions;
    }
}

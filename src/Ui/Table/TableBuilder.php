<?php namespace Anomaly\Streams\Platform\Ui\Table;

use Anomaly\Streams\Platform\Ui\Table\Contract\TableModelInterface;
use Laracasts\Commander\CommanderTrait;

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

    /**
     * The table model.
     *
     * @var null|string|TableModelInterface
     */
    protected $model = null;

    /**
     * The table entries handler.
     *
     * @var null|string
     */
    protected $entries = null;

    /**
     * The views configuration.
     *
     * @var array|string
     */
    protected $views = [];

    /**
     * The filters configuration.
     *
     * @var array|string
     */
    protected $filters = [];

    /**
     * The columns configuration.
     *
     * @var array|string
     */
    protected $columns = [];

    /**
     * The buttons configuration.
     *
     * @var array|string
     */
    protected $buttons = [];

    /**
     * The actions configuration.
     *
     * @var array|string
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
        $this->execute('Anomaly\Streams\Platform\Ui\Table\Command\BuildTableCommand', ['builder' => $this]);

        if (app('request')->isMethod('post')) {
            $this->execute(
                'Anomaly\Streams\Platform\Ui\Table\Command\HandleTablePostCommand',
                ['table' => $this->table]
            );
        }
    }

    /**
     * Make the table response.
     */
    public function make()
    {
        $this->build();

        if ($this->table->getResponse() === null) {

            $this->execute('Anomaly\Streams\Platform\Ui\Table\Command\LoadTableCommand', ['table' => $this->table]);

            $options = $this->table->getOptions();
            $data    = $this->table->getData();

            $this->table->setContent(
                view($options->get('view', 'streams::ui/table/index'), $data)
            );
        }
    }

    /**
     * Render the table.
     *
     * @return \Illuminate\Http\Response|\Illuminate\View\View|null
     */
    public function render()
    {
        $this->make();

        if ($this->table->getResponse() === null) {

            $options = $this->table->getOptions();
            $content = $this->table->getContent();

            return view($options->get('wrapper', 'streams::wrappers/blank'), compact('content'));
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
     * Set the table model.
     *
     * @param string|TableModelInterface $model
     * @return $this
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get the table model.
     *
     * @return null|string|TableModelInterface
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set the views configuration.
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
     * Get the views configuration.
     *
     * @return array
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * Set the filters configuration.
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
     * Get the filters configuration.
     *
     * @return array
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * Set the columns configuration.
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
     * Get the columns configuration.
     *
     * @return array
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * Set the buttons configuration.
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
     * Get the buttons configuration.
     *
     * @return array
     */
    public function getButtons()
    {
        return $this->buttons;
    }

    /**
     * Set the actions configuration.
     *
     * @param array $actions
     * @return $this
     */
    public function setActions(array $actions = [])
    {
        $this->actions = $actions;

        return $this;
    }

    /**
     * Get the actions configuration.
     *
     * @return array
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * Set the table entries handler.
     *
     * @param $entries
     * @return $this
     */
    public function setEntries($entries)
    {
        $this->entries = $entries;

        return $this;
    }

    /**
     * Get the table entries handler.
     *
     * @return null|string
     */
    public function getEntries()
    {
        return $this->entries;
    }
}

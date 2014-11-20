<?php namespace Anomaly\Streams\Platform\Ui\Table;

use Anomaly\Streams\Platform\Traits\CommandableTrait;
use Anomaly\Streams\Platform\Ui\Table\Command\BuildTableActionsCommand;
use Anomaly\Streams\Platform\Ui\Table\Command\BuildTableFiltersCommand;
use Anomaly\Streams\Platform\Ui\Table\Command\BuildTableHeadersCommand;
use Anomaly\Streams\Platform\Ui\Table\Command\BuildTableOptionsCommand;
use Anomaly\Streams\Platform\Ui\Table\Command\BuildTablePaginationCommand;
use Anomaly\Streams\Platform\Ui\Table\Command\BuildTableRowsCommand;
use Anomaly\Streams\Platform\Ui\Table\Command\BuildTableViewsCommand;

/**
 * Class TableBuilder
 *
 * This class returns prepared data for the Table in
 * order to send it then to the rendered view.
 *
 * The data coming from here should be as an array
 * preferably and pretty dumb. Stupid views = good views.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table
 */
class TableBuilder
{

    use CommandableTrait;

    /**
     * The table UI object.
     *
     * @var Table
     */
    protected $table;

    /**
     * Create a new TableBuilder instance.
     *
     * @param Table $table
     */
    function __construct(Table $table)
    {
        $this->table = $table;
    }

    /**
     * Return the views data.
     *
     * @return mixed
     */
    public function views()
    {
        return $this->execute(new BuildTableViewsCommand($this->table));
    }

    /**
     * Return the filters data.
     *
     * @return mixed
     */
    public function filters()
    {
        return $this->execute(new BuildTableFiltersCommand($this->table));
    }

    /**
     * Return the headers data.
     *
     * @return mixed
     */
    public function headers()
    {
        return $this->execute(new BuildTableHeadersCommand($this->table));
    }

    /**
     * Return the row data.
     *
     * @return mixed
     */
    public function rows()
    {
        return $this->execute(new BuildTableRowsCommand($this->table));
    }

    /**
     * Return the actions data.
     *
     * @return mixed
     */
    public function actions()
    {
        return $this->execute(new BuildTableActionsCommand($this->table));
    }

    /**
     * Return the pagination data.
     *
     * @return mixed
     */
    public function pagination()
    {
        return $this->execute(new BuildTablePaginationCommand($this->table));
    }

    /**
     * Return the options data.
     *
     * @return mixed
     */
    public function options()
    {
        return $this->execute(new BuildTableOptionsCommand($this->table));
    }
}
 
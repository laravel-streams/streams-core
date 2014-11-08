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
        $command = new BuildTableViewsCommand($this->table);

        return $this->execute($command);
    }

    /**
     * Return the filters data.
     *
     * @return mixed
     */
    public function filters()
    {
        $command = new BuildTableFiltersCommand($this->table);

        return $this->execute($command);
    }

    /**
     * Return the headers data.
     *
     * @return mixed
     */
    public function headers()
    {
        $command = new BuildTableHeadersCommand($this->table);

        return $this->execute($command);
    }

    /**
     * Return the row data.
     *
     * @return mixed
     */
    public function rows()
    {
        $command = new BuildTableRowsCommand($this->table);

        return $this->execute($command);
    }

    /**
     * Return the actions data.
     *
     * @return mixed
     */
    public function actions()
    {
        $command = new BuildTableActionsCommand($this->table);

        return $this->execute($command);
    }

    /**
     * Return the pagination data.
     *
     * @return mixed
     */
    public function pagination()
    {
        $command = new BuildTablePaginationCommand($this->table);

        return $this->execute($command);
    }

    /**
     * Return the options data.
     *
     * @return mixed
     */
    public function options()
    {
        $command = new BuildTableOptionsCommand($this->table);

        return $this->execute($command);
    }
}
 
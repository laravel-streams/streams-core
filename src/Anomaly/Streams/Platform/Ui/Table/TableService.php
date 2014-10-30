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
 * Class TableService
 *
 * This class returns prepared data for the TableUi in
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
class TableService
{

    use CommandableTrait;

    /**
     * The table UI object.
     *
     * @var TableUi
     */
    protected $ui;

    /**
     * Create a new TableService instance.
     *
     * @param TableUi $ui
     */
    function __construct(TableUi $ui)
    {
        $this->ui = $ui;
    }

    /**
     * Return the views data.
     *
     * @return mixed
     */
    public function views()
    {
        $command = new BuildTableViewsCommand($this->ui);

        return $this->execute($command);
    }

    /**
     * Return the filters data.
     *
     * @return mixed
     */
    public function filters()
    {
        $command = new BuildTableFiltersCommand($this->ui);

        return $this->execute($command);
    }

    /**
     * Return the headers data.
     *
     * @return mixed
     */
    public function headers()
    {
        $command = new BuildTableHeadersCommand($this->ui);

        return $this->execute($command);
    }

    /**
     * Return the row data.
     *
     * @return mixed
     */
    public function rows()
    {
        $command = new BuildTableRowsCommand($this->ui);

        return $this->execute($command);
    }

    /**
     * Return the actions data.
     *
     * @return mixed
     */
    public function actions()
    {
        $command = new BuildTableActionsCommand($this->ui);

        return $this->execute($command);
    }

    /**
     * Return the pagination data.
     *
     * @return mixed
     */
    public function pagination()
    {
        $command = new BuildTablePaginationCommand($this->ui);

        return $this->execute($command);
    }

    /**
     * Return the options data.
     *
     * @return mixed
     */
    public function options()
    {
        $command = new BuildTableOptionsCommand($this->ui);

        return $this->execute($command);
    }
}
 
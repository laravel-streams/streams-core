<?php namespace Streams\Platform\Ui\Table;

use Streams\Platform\Traits\CommandableTrait;
use Streams\Platform\Ui\Table\Command\BuildTableRowsCommand;
use Streams\Platform\Ui\Table\Command\BuildTableViewsCommand;
use Streams\Platform\Ui\Table\Command\BuildTableOptionsCommand;
use Streams\Platform\Ui\Table\Command\BuildTableActionsCommand;
use Streams\Platform\Ui\Table\Command\BuildTableFiltersCommand;
use Streams\Platform\Ui\Table\Command\BuildTableHeadersCommand;
use Streams\Platform\Ui\Table\Command\BuildTablePaginationCommand;
use Streams\Platform\Ui\Table\Contract\TableServiceInterface;

class TableService implements TableServiceInterface
{
    use CommandableTrait;

    /**
     * @var TableUi
     */
    protected $ui;

    /**
     * @param TableUi $ui
     */
    function __construct(TableUi $ui)
    {
        $this->ui = $ui;
    }

    /**
     * @return mixed
     */
    public function views()
    {
        $command = new BuildTableViewsCommand($this->ui);

        return $this->execute($command);
    }

    /**
     * @return mixed
     */
    public function filters()
    {
        $command = new BuildTableFiltersCommand($this->ui);

        return $this->execute($command);
    }

    /**
     * @return mixed
     */
    public function headers()
    {
        $command = new BuildTableHeadersCommand($this->ui);

        return $this->execute($command);
    }

    /**
     * @return mixed
     */
    public function rows()
    {
        $command = new BuildTableRowsCommand($this->ui);

        return $this->execute($command);
    }

    /**
     * @return mixed
     */
    public function actions()
    {
        $command = new BuildTableActionsCommand($this->ui);

        return $this->execute($command);
    }

    /**
     * @return mixed
     */
    public function pagination()
    {
        $command = new BuildTablePaginationCommand($this->ui);

        return $this->execute($command);
    }

    /**
     * @return mixed
     */
    public function options()
    {
        $command = new BuildTableOptionsCommand($this->ui);

        return $this->execute($command);
    }
}
 
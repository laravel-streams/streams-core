<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\TableUi;

class BuildTableRowsCommand
{
    protected $ui;

    function __construct(TableUi $ui)
    {
        $this->ui = $ui;
    }

    /**
     * @return mixed
     */
    public function getUi()
    {
        return $this->ui;
    }
}
 
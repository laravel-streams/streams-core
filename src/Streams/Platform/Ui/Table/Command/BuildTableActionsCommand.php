<?php namespace Streams\Platform\Ui\Table\Command;

use Streams\Platform\Ui\Table\TableUi;

class BuildTableActionsCommand
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
 
<?php namespace Streams\Platform\Ui\Table\Command;

use Streams\Platform\Ui\Table\TableUi;

class BuildTableButtonsCommand
{
    protected $ui;

    protected $entry;

    function __construct(TableUi $ui, $entry)
    {
        $this->ui    = $ui;
        $this->entry = $entry;
    }

    /**
     * @return mixed
     */
    public function getUi()
    {
        return $this->ui;
    }

    /**
     * @return mixed
     */
    public function getEntry()
    {
        return $this->entry;
    }
}
 
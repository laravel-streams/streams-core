<?php namespace Streams\Core\Ui\Component;

use Streams\Core\Ui\TableUi;

class TableComponent extends Component
{
    /**
     * The TableUi object.
     *
     * @var \Streams\Ui\TableUi
     */
    protected $ui;

    /**
     * Create a new TableComponent instance.
     *
     * @param TableUi $ui
     */
    public function __construct(TableUi $ui = null)
    {
        $this->ui = $ui;
    }
}

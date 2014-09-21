<?php namespace Streams\Platform\Ui\Builder;

use Streams\Platform\Ui\TableUi;

abstract class TableBuilderAbstract extends BuilderAbstract
{
    /**
     * The UI object.
     *
     * @var array
     */
    protected $ui;

    /**
     * Create a new TableBuilderAbstract instance.
     *
     * @param TableUi $ui
     */
    public function __construct(TableUi $ui)
    {
        $this->ui = $ui;
    }
}

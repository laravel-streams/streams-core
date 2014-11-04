<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\Table;

/**
 * Class BuildTableColumnsCommand
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class BuildTableColumnsCommand
{

    /**
     * The table UI object.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Table
     */
    protected $ui;

    /**
     * The entry payload.
     *
     * @var
     */
    protected $entry;

    /**
     * Create a new BuildTableColumnsCommand instance.
     *
     * @param Table $ui
     * @param         $entry
     */
    function __construct(Table $ui, $entry)
    {
        $this->ui    = $ui;
        $this->entry = $entry;
    }

    /**
     * Get the table UI object.
     *
     * @return Table
     */
    public function getUi()
    {
        return $this->ui;
    }

    /**
     * Get the entry payload.
     *
     * @return mixed
     */
    public function getEntry()
    {
        return $this->entry;
    }
}
 
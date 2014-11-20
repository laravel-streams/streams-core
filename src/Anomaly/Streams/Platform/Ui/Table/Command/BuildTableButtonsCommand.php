<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Ui\Table\Table;

/**
 * Class BuildTableButtonsCommand
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class BuildTableButtonsCommand
{

    /**
     * The table object.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Table
     */
    protected $table;

    /**
     * The entry payload.
     *
     * @var \Anomaly\Streams\Platform\Entry\Contract\EntryInterface
     */
    protected $entry;

    /**
     * Create a new BuildTableButtonsCommand instance.
     *
     * @param Table          $table
     * @param EntryInterface $entry
     */
    function __construct(Table $table, EntryInterface $entry)
    {
        $this->table = $table;
        $this->entry = $entry;
    }

    /**
     * Get the table object.
     *
     * @return Table
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Get the entry payload.
     *
     * @return EntryInterface
     */
    public function getEntry()
    {
        return $this->entry;
    }
}
 
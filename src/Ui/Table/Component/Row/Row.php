<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Row;

use Anomaly\Streams\Platform\Ui\Button\ButtonCollection;
use Anomaly\Streams\Platform\Ui\Table\Component\Row\Contract\RowInterface;
use Illuminate\Support\Collection;

/**
 * Class Row
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Row
 */
class Row implements RowInterface
{

    /**
     * The row entry.
     *
     * @var mixed
     */
    protected $entry;

    /**
     * The row columns.
     *
     * @var Collection
     */
    protected $columns;

    /**
     * The row buttons.
     *
     * @var ButtonCollection
     */
    protected $buttons;

    /**
     * Set the row buttons.
     *
     * @param $buttons
     * @return $this
     */
    public function setButtons($buttons)
    {
        $this->buttons = $buttons;

        return $this;
    }

    /**
     * Get the row buttons.
     *
     * @return mixed
     */
    public function getButtons()
    {
        return $this->buttons;
    }

    /**
     * Set the row columns.
     *
     * @param $columns
     * @return $this
     */
    public function setColumns($columns)
    {
        $this->columns = $columns;

        return $this;
    }

    /**
     * Get the row columns.
     *
     * @return mixed
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * Set the row entry.
     *
     * @param $entry
     * @return $this
     */
    public function setEntry($entry)
    {
        $this->entry = $entry;

        return $this;
    }

    /**
     * Get the row entry.
     *
     * @return mixed
     */
    public function getEntry()
    {
        return $this->entry;
    }
}

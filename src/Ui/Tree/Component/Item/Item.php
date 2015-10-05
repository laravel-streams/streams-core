<?php namespace Anomaly\Streams\Platform\Ui\Tree\Component\Item;

use Anomaly\Streams\Platform\Ui\Button\ButtonCollection;
use Anomaly\Streams\Platform\Ui\Tree\Component\Column\ColumnCollection;
use Anomaly\Streams\Platform\Ui\Tree\Component\Item\Contract\ItemInterface;

/**
 * Class Item
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Tree\Component\Item
 */
class Item implements ItemInterface
{

    /**
     * The item ID.
     *
     * @var int
     */
    protected $id;

    /**
     * The parent ID.
     *
     * @var int
     */
    protected $parent;

    /**
     * The column collection.
     *
     * @var ColumnCollection
     */
    protected $columns;

    /**
     * The item buttons.
     *
     * @var ButtonCollection
     */
    protected $buttons;

    /**
     * Get the ID.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the ID.
     *
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the parent ID.
     *
     * @return int
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set the parent ID.
     *
     * @param $parent
     * @return $this
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get the columns.
     *
     * @return ColumnCollection
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * Set the columns.
     *
     * @param ColumnCollection $columns
     * @return $this
     */
    public function setColumns(ColumnCollection $columns)
    {
        $this->columns = $columns;

        return $this;
    }

    /**
     * Get the buttons.
     *
     * @return ButtonCollection
     */
    public function getButtons()
    {
        return $this->buttons;
    }

    /**
     * Set the buttons.
     *
     * @param ButtonCollection $buttons
     * @return $this
     */
    public function setButtons(ButtonCollection $buttons)
    {
        $this->buttons = $buttons;

        return $this;
    }
}

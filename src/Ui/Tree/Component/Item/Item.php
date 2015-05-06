<?php namespace Anomaly\Streams\Platform\Ui\Tree\Component\Item;

use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Ui\Button\ButtonCollection;
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
     * The item entry.
     *
     * @var EloquentModel
     */
    protected $entry;

    /**
     * The item value.
     *
     * @var string
     */
    protected $value;

    /**
     * The item buttons.
     *
     * @var ButtonCollection
     */
    protected $buttons;

    /**
     * Get the entry.
     *
     * @return EloquentModel
     */
    public function getEntry()
    {
        return $this->entry;
    }

    /**
     * Set the entry.
     *
     * @param EloquentModel $entry
     * @return $this
     */
    public function setEntry(EloquentModel $entry)
    {
        $this->entry = $entry;

        return $this;
    }

    /**
     * Get the value.
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value.
     *
     * @param $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Return the root flag.
     *
     * @return bool
     */
    public function isRoot()
    {
        return $this->getParentId() == null;
    }

    /**
     * Get the parent ID.
     *
     * @return int
     */
    public function getParentId()
    {
        return $this->entry->parent_id;
    }

    /**
     * Get the entry ID.
     *
     * @return int
     */
    public function getEntryId()
    {
        return $this->entry->getId();
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

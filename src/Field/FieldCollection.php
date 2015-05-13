<?php namespace Anomaly\Streams\Platform\Field;

use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Model\EloquentCollection;

/**
 * Class FieldCollection
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Field
 */
class FieldCollection extends EloquentCollection
{

    /**
     * Create a new FieldCollection instance.
     *
     * @param array $items
     */
    public function __construct($items = [])
    {
        /* @var FieldInterface $item */
        foreach ($items as $item) {
            $this->items[$item->getSlug()] = $item;
        }
    }

    /**
     * Return only unassigned fields.
     *
     * @return static|FieldCollection
     */
    public function unassigned()
    {
        $unassigned = [];

        /* @var FieldInterface $item */
        foreach ($this->items as $item) {
            if (!$item->hasAssignments()) {
                $unassigned[] = $item;
            }
        }

        return new static($unassigned);
    }

    /**
     * Return only unlocked fields.
     *
     * @return static|FieldCollection
     */
    public function unlocked()
    {
        $unlocked = [];

        /* @var FieldInterface $item */
        foreach ($this->items as $item) {
            if (!$item->isLocked()) {
                $unlocked[] = $item;
            }
        }

        return new static($unlocked);
    }
}

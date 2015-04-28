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
                $unassigned[$item->getSlug()] = $item;
            }
        }

        return new static($unassigned);
    }

    /**
     * Get a dictionary keyed by slugs.
     *
     * @param  \ArrayAccess|array $items
     * @return array
     */
    public function getDictionary($items = null)
    {
        $items = is_null($items) ? $this->items : $items;

        $dictionary = array();

        /* @var FieldInterface $item */
        foreach ($items as $item) {
            $dictionary[$item->getSlug()] = $item;
        }

        return $dictionary;
    }
}

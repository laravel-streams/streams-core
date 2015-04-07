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

<?php namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Model\EloquentCollection;

/**
 * Class EntryCollection
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Entry
 */
class EntryCollection extends EloquentCollection
{

    /**
     * Return the sorted entries.
     *
     * @param bool|false $reverse
     * @return static
     */
    public function sorted($direction = 'asc')
    {
        $items = [];

        /* @var EntryInterface $item */
        foreach ($this->items as $item) {
            $items[$item->getSortOrder()] = $item;
        }

        ksort($items);

        if (strtolower($direction) == 'desc') {
            $items = array_reverse($items);
        }

        return self::make($items);
    }

}

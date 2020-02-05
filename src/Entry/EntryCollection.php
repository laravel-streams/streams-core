<?php namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Model\EloquentCollection;
use Anomaly\Streams\Platform\Support\Decorator;

/**
 * Class EntryCollection
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class EntryCollection extends EloquentCollection
{

    /**
     * Return the sorted entries.
     *
     * @param  bool|false $reverse
     * @return static
     */
    public function sorted($direction = 'asc')
    {
        $items = [];

        /* @var EntryInterface $item */
        foreach ($this->items as $item) {
            $items[$item->sort_order] = $item;
        }

        ksort($items);

        if (strtolower($direction) == 'desc') {
            $items = array_reverse($items);
        }

        return self::make($items);
    }
}

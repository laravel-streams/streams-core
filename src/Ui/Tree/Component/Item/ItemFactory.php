<?php

namespace Anomaly\Streams\Platform\Ui\Tree\Component\Item;

use Anomaly\Streams\Platform\Support\Facades\Hydrator;
use Anomaly\Streams\Platform\Ui\Tree\Component\Item\Contract\ItemInterface;

/**
 * Class ItemFactory
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ItemFactory
{

    /**
     * Make an item.
     *
     * @param  array         $parameters
     * @return ItemInterface
     */
    public function make(array $parameters)
    {
        $item = app()->make(Item::class, $parameters);

        Hydrator::hydrate($item, $parameters);

        return $item;
    }
}

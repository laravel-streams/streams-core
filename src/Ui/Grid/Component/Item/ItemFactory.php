<?php

namespace Anomaly\Streams\Platform\Ui\Grid\Component\Item;

use Anomaly\Streams\Platform\Support\Facades\Hydrator;
use Anomaly\Streams\Platform\Ui\Grid\Component\Item\Contract\ItemInterface;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\App;

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
        $item = App::make(Item::class, $parameters);

        Hydrator::hydrate($item, $parameters);

        return $item;
    }
}

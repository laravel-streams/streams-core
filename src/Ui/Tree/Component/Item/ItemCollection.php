<?php namespace Anomaly\Streams\Platform\Ui\Tree\Component\Item;

use Anomaly\Streams\Platform\Support\Collection;
use Anomaly\Streams\Platform\Ui\Tree\Component\Item\Contract\ItemInterface;

/**
 * Class ItemCollection
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Tree\Component\Item
 */
class ItemCollection extends Collection
{

    /**
     * Return only root items.
     *
     * @return ItemCollection
     */
    public function root()
    {
        $root = [];

        /* @var ItemInterface $item */
        foreach ($this->items as $item) {
            if ($item->isRoot()) {
                $root[] = $root;
            }
        }

        return new static($root);
    }
}

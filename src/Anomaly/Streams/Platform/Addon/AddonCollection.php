<?php namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Support\Collection;

class AddonCollection extends Collection
{

    /**
     * Create a new collection.
     *
     * @param  mixed $items
     * @return void
     */
    public function __construct($items = array())
    {
        $items = is_null($items) ? [] : $this->getArrayableItems($items);

        foreach ($items as $item) {

            if ($item instanceof Addon) {

                $this->items[$item->getSlug()] = $item;
                
            }

        }
    }

    public function push($addon)
    {
        $this->items[$addon->getSlug()] = $addon;
    }

    public function findBySlug($slug)
    {
        if (isset($this->items[$slug])) {

            return $this->items[$slug];

        }

        return null;
    }

}

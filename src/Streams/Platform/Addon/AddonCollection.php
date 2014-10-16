<?php namespace Streams\Platform\Addon;

use Streams\Platform\Support\Decorator;
use Streams\Platform\Support\Collection;

class AddonCollection extends Collection
{
    public function push($value)
    {
        parent::push(app('streams.decorator')->decorate($value));
    }

    /**
     * Find an addon by it's slug.
     *
     * @param $slug
     * @return null
     */
    public function findBySlug($slug)
    {
        $addon = null;

        foreach ($this->items as $item) {
            if ($item->getSlug() == $slug) {
                $addon = $item;
            }
        }

        return $addon;
    }
}

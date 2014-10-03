<?php namespace Streams\Platform\Addon;

use Streams\Platform\Support\Collection;

class AddonCollection extends Collection
{
    /**
     * Find an addon by it's slug.
     *
     * @param $slug
     * @return null
     */
    public function findBySlug($slug)
    {
        foreach ($this->items as $item) {
            if ($item->getSlug() === $slug) {
                return $item;
            }
        }

        return null;
    }
}

<?php namespace Streams\Platform\Addon;

use Streams\Platform\Support\Decorator;
use Streams\Platform\Support\Collection;

class AddonCollection extends Collection
{
    public function findBySlug($slug)
    {
        $addon = null;

        foreach ($this->items as $item) {
            if ($item->slug == $slug) {
                $addon = $item;
            }
        }

        return $addon;
    }
}

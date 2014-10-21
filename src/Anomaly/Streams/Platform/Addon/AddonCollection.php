<?php namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Support\Decorator;
use Anomaly\Streams\Platform\Support\Collection;

class AddonCollection extends Collection
{
    public function push($addon)
    {
        $this->items[$addon->slug] = $addon;
    }

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

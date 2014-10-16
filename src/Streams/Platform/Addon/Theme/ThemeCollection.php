<?php namespace Streams\Platform\Addon\Theme;

use Streams\Platform\Addon\AddonCollection;

class ThemeCollection extends AddonCollection
{
    public function active()
    {
        foreach ($this->items as $item) {
            if ($item->isActive()) {
                return $item;
            }
        }
    }
}
 
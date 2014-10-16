<?php namespace Streams\Platform\Addon\Theme;

use Streams\Platform\Addon\AddonCollection;

class ThemeCollection extends AddonCollection
{
    public function active()
    {
        $active = null;

        foreach ($this->items as $item) {
            if ($item->isActive()) {
                $active = $item;
            }
        }

        return $active;
    }
}
 
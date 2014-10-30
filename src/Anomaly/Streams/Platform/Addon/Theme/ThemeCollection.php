<?php namespace Anomaly\Streams\Platform\Addon\Theme;

use Anomaly\Streams\Platform\Addon\AddonCollection;

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
 
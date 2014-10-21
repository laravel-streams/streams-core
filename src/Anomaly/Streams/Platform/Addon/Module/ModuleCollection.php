<?php namespace Anomaly\Streams\Platform\Addon\Module;

use Anomaly\Streams\Platform\Addon\AddonCollection;

class ModuleCollection extends AddonCollection
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

    public function installed()
    {
        $installed = [];

        foreach ($this->items as $item) {

            if ($item->isInstalled()) {

                $installed[] = $item;

            }
        }

        return self::make($installed);
    }

    public function enabled()
    {
        $enabled = [];

        foreach ($this->items as $item) {

            if ($item->isInstalled() and $item->isEnabled()) {

                $enabled[] = $item;

            }

        }

        return self::make($enabled);
    }
}

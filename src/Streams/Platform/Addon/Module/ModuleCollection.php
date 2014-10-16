<?php namespace Streams\Platform\Addon\Module;

use Streams\Platform\Addon\AddonCollection;

class ModuleCollection extends AddonCollection
{
    public function active()
    {
        foreach ($this->items as $item) {
            if ($item->isActive()) {
                return $item;
            }
        }
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

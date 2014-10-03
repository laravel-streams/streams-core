<?php namespace Streams\Platform\Addon\Module;

use Streams\Platform\Addon\AddonCollection;

class ModuleCollection extends AddonCollection
{
    /**
     * Return only installed addons.
     *
     * @return Collection
     */
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

    /**
     * Return only enabled addons (which must be installed).
     *
     * @return Collection
     */
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

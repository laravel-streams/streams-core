<?php namespace Streams\Core\Addon\Collection;

use Illuminate\Support\Collection;

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

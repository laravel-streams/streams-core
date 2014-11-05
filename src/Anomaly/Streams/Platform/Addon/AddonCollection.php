<?php namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Support\Collection;

/**
 * Class AddonCollection
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon
 */
class AddonCollection extends Collection
{

    /**
     * Push an addon to the collection.
     *
     * @param mixed $addon
     */
    public function push($addon)
    {
        $this->items[$addon->getSlug()] = $addon;
    }

    /**
     * Find an addon by it's slug.
     *
     * @param $slug
     * @return null
     */
    public function findBySlug($slug)
    {
        if (isset($this->items[$slug])) {

            return $this->items[$slug];
        }

        return null;
    }
}

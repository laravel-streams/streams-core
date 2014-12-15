<?php namespace Anomaly\Streams\Platform\Addon\Distribution;

use Anomaly\Streams\Platform\Addon\AddonCollection;

/**
 * Class DistributionCollection
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Distribution
 */
class DistributionCollection extends AddonCollection
{

    /**
     * Return the active distribution.
     *
     * @return Distribution|null
     */
    public function active()
    {
        foreach ($this->items as $item) {
            if ($this->distributionIsActive($item)) {
                return $item;
            }
        }

        return null;
    }

    /**
     * Return whether a given distribution is active or not.
     *
     * @param Distribution $item
     * @return bool
     */
    protected function distributionIsActive(Distribution $item)
    {
        return $item->getSlug() == config('streams::config.distribution');
    }
}

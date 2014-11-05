<?php namespace Anomaly\Streams\Platform\Addon\Extension;

use Anomaly\Streams\Platform\Addon\AddonCollection;

/**
 * Class ExtensionCollection
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Extension
 */
class ExtensionCollection extends AddonCollection
{

    /**
     * Get all extensions matching a pattern.
     *
     * @param $pattern
     * @return static
     */
    public function getAll($pattern)
    {
        $matches = [];

        /**
         * Break up our pattern into components we can match up
         * with our available extensions.
         */
        list($namespace, $extension) = explode('::', $pattern);
        list($addonType, $addonSlug) = explode('.', $namespace);

        foreach ($this->items as $item) {

            $slug = $item->getSlug();

            if (starts_with($slug, "{$addonSlug}_{$addonType}_")) {

                if (ends_with($slug, "_{$extension}")) {

                    $matches[] = $item;
                }
            }
        }

        return self::make($matches);
    }

    /**
     * Find a specific extension by it's reference.
     *
     * @param mixed $reference
     * @return null
     */
    public function find($reference)
    {
        /**
         * We can simply replace with underscores here
         * and we are left with the addon slug.
         */
        $slug = str_replace(['.', '::'], '_', $reference);

        foreach ($this->items as $item) {

            if ($item->getSlug() == $slug) {

                return $item;
            }
        }

        return null;
    }
}

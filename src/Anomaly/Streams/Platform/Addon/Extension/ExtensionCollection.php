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
     * @param $key
     * @return static
     */
    public function search($key, $strict = true)
    {
        $matches = [];

        /**
         * Break up our pattern into components we can match up
         * with our available extensions.
         */
        list($namespace, $extension) = explode('::', $key);
        list($addonType, $addonSlug) = explode('.', $namespace);

        if ($extension == '*') {

            $extension = false;
        }

        if ($extension != '*') {

            list($extensionType, $extensionSlug) = explode('.', $extension);

            $extension = "_{$extensionSlug}_{$extensionType}";

            if ($extensionSlug == '*') {

                $extension = "_{$extensionType}";
            }
        }

        foreach ($this->items as $item) {

            $slug = $item->getSlug();

            if ($strict) {

                /**
                 * If searching strict then look only at the
                 * beginning and ending of the extension slug.
                 */
                if (starts_with($slug, "{$addonSlug}_{$addonType}_")) {

                    if ($extension) {

                        if (ends_with($slug, $extension)) {

                            $matches[] = $item;

                            continue;
                        }
                    }
                }
            } else {

                /**
                 * If not searching strict than just do simple string
                 * matches on the extension slug.
                 */
                if (str_contains($slug, "{$addonSlug}_{$addonType}")) {

                    if ($extension) {

                        if (str_contains($slug, $extension)) {

                            $matches[] = $item;
                        }
                    }
                }
            }
        }

        return self::make($matches);
    }

    /**
     * Get an extension by it's reference.
     *
     * @param mixed $key
     * @return null
     */
    public function get($key, $default = null)
    {
        /**
         * We can simply replace with underscores here
         * and we are left with the addon slug.
         */
        list($namespace, $extension) = explode('::', $key);
        list($addonType, $addonSlug) = explode('.', $namespace);
        list($extensionSlug, $extensionType) = explode('.', $extension);

        $slug = "{$addonSlug}_{$addonType}_{$extensionSlug}_{$extensionType}";

        if (isset($this->items[$slug])) {

            return $this->items[$slug];
        }

        if ($default) {

            $this->get($default);
        }

        return null;
    }
}

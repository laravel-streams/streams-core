<?php namespace Anomaly\Streams\Platform\Addon\Extension;

use Anomaly\Streams\Platform\Addon\AddonCollection;

/**
 * Class ExtensionCollection
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Extension
 */
class ExtensionCollection extends AddonCollection
{

    /**
     * Find all extensions matching a pattern.
     *
     * Example: module.users::authenticator.*
     * Example: module.users::*
     *
     * @param  $pattern
     * @return static
     */
    public function matching($pattern)
    {
        $matches = [];

        /**
         * Break up our pattern into components we can match up
         * with our available extensions.
         */
        list($namespace, $extension) = explode('::', $pattern);
        list($addonType, $addonSlug) = explode('.', $namespace);

        if ($extension !== '*') {

            list($extensionType, $extensionSlug) = explode('.', $extension);
        } else {

            $extensionSlug = '*';
            $extensionType = '*';
        }

        $pattern = "{$addonType}_{$addonSlug}_{$extensionType}_{$extensionSlug}";

        foreach ($this->items as $item) {
            if ($this->extensionSlugIsPattern($item, $pattern)) {
                $matches[] = $item;
            }
        }

        return self::make($matches);
    }

    /**
     * Get an extension by it's reference.
     *
     * Example: module.users::authenticator.default
     *
     * @param  mixed $key
     * @return mixed
     */
    public function get($key, $default = null)
    {
        list($namespace, $extension) = explode('::', $key);
        list($addonType, $addonSlug) = explode('.', $namespace);
        list($extensionType, $extensionSlug) = explode('.', $extension);

        $slug = "{$addonSlug}_{$addonType}_{$extensionSlug}_{$extensionType}";

        if (isset($this->items[$slug])) {
            return $this->items[$slug];
        }

        if ($default) {
            $this->get($default);
        }

        return null;
    }

    /**
     * Return whether a given extension's slug
     * matches the given pattern.
     *
     * @param  Extension $extension
     * @param            $pattern
     * @return bool
     */
    protected function extensionSlugIsPattern(Extension $extension, $pattern)
    {
        return (str_is($pattern, $extension->getSlug()));
    }
}

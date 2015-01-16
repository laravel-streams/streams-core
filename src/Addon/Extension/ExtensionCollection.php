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
     * @return static|ExtensionCollection
     */
    public function matching($pattern)
    {
        $matches = [];

        foreach ($this->items as $item) {
            if ($item instanceof Extension && str_is($pattern, $item->getIdentifier())) {
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
        foreach ($this->items as $item) {
            if ($item instanceof Extension && $item->getIdentifier() == $key) {
                return $item;
            }
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

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
     * Search for and return matching extensions.
     *
     * @param mixed $pattern
     * @param bool  $strict
     * @return ExtensionCollection
     */
    public function search($pattern, $strict = false)
    {
        $matches = [];

        foreach ($this->items as $item) {
            if ($item instanceof Extension && str_is($pattern, $item->getProvides())) {
                $matches[] = $item;
            }
        }

        return self::make($matches);
    }

    /**
     * Get an extension by it's reference.
     *
     * Example: extension.users::authenticator.default
     *
     * @param  mixed $key
     * @return mixed
     */
    public function get($key, $default = null)
    {
        foreach ($this->items as $item) {
            if ($item instanceof Extension && $item->getProvides() == $key) {
                return $item;
            }
        }

        if ($default) {
            $this->get($default);
        }

        return null;
    }

    /**
     * Return the active extension.
     *
     * @return Extension
     */
    public function active()
    {
        foreach ($this->items as $item) {
            if ($item instanceof Extension && $item->isActive()) {
                return $item;
            }
        }

        return null;
    }

    /**
     * Return installed extensions.
     *
     * @return static
     */
    public function installed()
    {
        $installed = [];

        foreach ($this->items as $item) {
            if ($item instanceof Extension && $item->isInstalled()) {
                $installed[] = $item;
            }
        }

        return self::make($installed);
    }

    /**
     * Return uninstalled extensions.
     *
     * @return static
     */
    public function uninstalled()
    {
        $installed = [];

        foreach ($this->items as $item) {
            if ($item instanceof Extension && !$item->isInstalled()) {
                $installed[] = $item;
            }
        }

        return self::make($installed);
    }

    /**
     * Return enabled extensions.
     *
     * @return static
     */
    public function enabled()
    {
        $enabled = [];

        foreach ($this->items as $item) {
            if ($item instanceof Extension && $item->isEnabled()) {
                $enabled[] = $item;
            }
        }

        return self::make($enabled);
    }

    /**
     * Determine if a extension is installed or not.
     *
     * @param  $slug
     * @return bool
     */
    public function isInstalled($slug)
    {
        if (!isset($this->items[$slug])) {
            return false;
        }

        $item = $this->items[$slug];

        if ($item instanceof Extension) {
            return $item->isInstalled();
        }

        return false;
    }

    /**
     * Set the installed and enabled states.
     *
     * @param array $installed
     */
    public function setStates(array $states)
    {
        foreach ($states as $state) {
            if ($extension = $this->findBySlug($state->slug)) {
                $this->setFlags($extension, $state);
            }
        }
    }

    /**
     * Set the extension flags from a state object.
     *
     * @param Extension $extension
     * @param           $state
     */
    protected function setFlags(Extension $extension, $state)
    {
        $extension->setEnabled($state->enabled);
        $extension->setInstalled($state->installed);
    }
}

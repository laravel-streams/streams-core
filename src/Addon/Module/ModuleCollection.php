<?php namespace Anomaly\Streams\Platform\Addon\Module;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Illuminate\Support\Collection;

/**
 * Class ModuleCollection
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Module
 */
class ModuleCollection extends AddonCollection
{

    /**
     * Return the active module.
     *
     * @return Module
     */
    public function active()
    {
        foreach ($this->items as $item) {
            if ($item instanceof Module && $item->isActive()) {
                return $item;
            }
        }

        return null;
    }

    /**
     * Return installed modules.
     *
     * @return static
     */
    public function installed()
    {
        $installed = [];

        foreach ($this->items as $item) {
            if ($item instanceof Module && $item->isInstalled()) {
                $installed[] = $item;
            }
        }

        return self::make($installed);
    }

    /**
     * Return uninstalled modules.
     *
     * @return static
     */
    public function uninstalled()
    {
        $installed = [];

        foreach ($this->items as $item) {
            if ($item instanceof Module && !$item->isInstalled()) {
                $installed[] = $item;
            }
        }

        return self::make($installed);
    }

    /**
     * Return enabled modules.
     *
     * @return static
     */
    public function enabled()
    {
        $enabled = [];

        foreach ($this->items as $item) {
            if ($item instanceof Module && $item->isEnabled()) {
                $enabled[] = $item;
            }
        }

        return self::make($enabled);
    }

    /**
     * Determine if a module is installed or not.
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

        if ($item instanceof Module) {
            return $item->isInstalled();
        }

        return false;
    }

    /**
     * Set the installed and enabled states.
     *
     * @param Collection $installed
     */
    public function setStates(Collection $states)
    {
        foreach ($states as $state) {
            if (isset($this->items[$state->slug]) && $module = $this->items[$state->slug]) {
                $this->setFlags($module, $state);
                $this->push($module);
            }
        }
    }

    /**
     * Set the module flags from a state object.
     *
     * @param Module $module
     * @param        $state
     */
    protected function setFlags(Module $module, $state)
    {
        $module->setEnabled($state->enabled);
        $module->setInstalled($state->installed);
    }
}

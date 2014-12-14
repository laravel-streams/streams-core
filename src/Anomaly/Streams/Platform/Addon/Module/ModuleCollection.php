<?php namespace Anomaly\Streams\Platform\Addon\Module;

use Anomaly\Streams\Platform\Addon\AddonCollection;

/**
 * Class ModuleCollection
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Module
 */
class ModuleCollection extends AddonCollection
{
    /**
     * Return the active module.
     *
     * @return null
     */
    public function active()
    {
        foreach ($this->items as $item) {
            if ($this->moduleIsActive($item)) {
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
            if ($this->moduleIsInstalled($item)) {
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
            if ($this->moduleIsEnabled($item)) {
                $enabled[] = $item;
            }
        }

        return self::make($enabled);
    }

    /**
     * Determine if a module is installed or not.
     *
     * @param $slug
     * @return bool
     */
    public function isInstalled($slug)
    {
        if (!isset($this->items[$slug])) {
            return false;
        }

        if (!$this->moduleIsInstalled($this->items[$slug])) {
            return false;
        }

        return true;
    }

    /**
     * Set the installed and enabled states.
     *
     * @param array $installed
     */
    public function setStates(array $states)
    {
        foreach ($states as $state) {
            if (isset($this->items[$state->slug]) && $module = $this->items[$state->slug]) {
                $this->setFlags($module, $state);
                $this->push($module);
            }
        }
    }

    /**
     * Return if the module is active or not.
     *
     * @param Module $module
     * @return bool
     */
    protected function moduleIsActive(Module $module)
    {
        return $module->isActive();
    }

    /**
     * Return if the module is enabled or not.
     *
     * @param Module $module
     * @return bool
     */
    protected function moduleIsEnabled(Module $module)
    {
        return $module->isEnabled();
    }

    /**
     * Return if the module is installed or not.
     *
     * @param Module $module
     * @return bool
     */
    protected function moduleIsInstalled(Module $module)
    {
        return $module->isInstalled();
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

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

            if ($item->isActive()) {

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

            if ($item->isInstalled()) {

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

            if ($item->isEnabled()) {

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

        if (!$this->items[$slug]->isInstalled()) {

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

                $module->setEnabled($state->is_enabled);
                $module->setInstalled($state->is_installed);

                $this->push($module);
            }
        }
    }
}

<?php namespace Anomaly\Streams\Platform\Addon\Module;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Support\Authorizer;

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
     * Return navigate-able modules.
     *
     * @return ModuleCollection
     */
    public function navigation()
    {
        $navigation = [];

        /* @var Module $item */
        foreach ($this->items as $item) {
            if ($item->getNavigation()) {
                $navigation[] = $item;
            }
        }

        return self::make($navigation)
            ->enabled()
            ->accessible();
    }

    /**
     * Return accessible modules.
     *
     * @return ModuleCollection
     */
    public function accessible()
    {
        $accessible = [];

        /* @var Authorizer $authorizer */
        $authorizer = app('Anomaly\Streams\Platform\Support\Authorizer');

        /* @var Module $item */
        foreach ($this->items as $item) {
            if ($authorizer->authorize($item->getNamespace('*'))) {
                $accessible[] = $item;
            }
        }

        return self::make($accessible);
    }

    /**
     * Return enabled modules.
     *
     * @return ModuleCollection
     */
    public function enabled()
    {
        $enabled = [];

        /* @var Module $item */
        foreach ($this->items as $item) {
            if ($item->isEnabled()) {
                $enabled[] = $item;
            }
        }

        return self::make($enabled);
    }

    /**
     * Return the active module.
     *
     * @return Module
     */
    public function active()
    {
        /* @var Module $item */
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
     * @return ModuleCollection
     */
    public function installed()
    {
        $installed = [];

        /* @var Module $item */
        foreach ($this->items as $item) {
            if ($item->isInstalled()) {
                $installed[] = $item;
            }
        }

        return self::make($installed);
    }

    /**
     * Return uninstalled modules.
     *
     * @return ModuleCollection
     */
    public function uninstalled()
    {
        $installed = [];

        /* @var Module $item */
        foreach ($this->items as $item) {
            if (!$item->isInstalled()) {
                $installed[] = $item;
            }
        }

        return self::make($installed);
    }

    /**
     * Set the installed and enabled states.
     *
     * @param array $installed
     */
    public function setStates(array $states)
    {
        foreach ($states as $state) {
            if ($module = $this->get($state->namespace)) {
                $this->setFlags($module, $state);
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

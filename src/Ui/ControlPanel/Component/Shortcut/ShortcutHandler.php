<?php

namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Shortcut;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Support\Facades\Resolver;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Shortcut\Event\GatherShortcuts;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class ShortcutHandler
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ShortcutHandler
{

    /**
     * The module collection.
     *
     * @var ModuleCollection
     */
    protected $modules;

    /**
     * Create a new ShortcutHandler instance.
     *
     * @param ModuleCollection $modules
     */
    public function __construct(ModuleCollection $modules)
    {
        $this->modules  = $modules;
    }

    /**
     * Handle the shortcuts.
     *
     * @param ControlPanelBuilder $builder
     */
    public function handle(ControlPanelBuilder $builder)
    {

        /**
         * Start off with no
         * shortcuts for now.
         */
        $builder->setShortcuts([]);

        /* @var Module $module */
        foreach ($this->modules->instances() as $module) {

            $shortcuts = $module->getShortcuts();

            if ($shortcuts && is_array($shortcuts)) {
                $builder->addShortcuts($module->getShortcuts());
            }

            if ($shortcuts && is_string($shortcuts)) {
                Resolver::resolve($shortcuts . '@handle', compact('builder'));
            }

            /*
             * If the module has a shortcuts handler
             * let that HANDLE the shortcuts.
             */
            if (!$shortcuts && class_exists($shortcuts = get_class($module) . 'Shortcuts')) {
                Resolver::resolve($shortcuts . '@handle', compact('builder'));
            }
        }

        event(new GatherShortcuts($builder));
    }
}

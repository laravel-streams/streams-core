<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Shortcut;

use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Support\Resolver;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Shortcut\Event\GatherShortcuts;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;
use Illuminate\Contracts\Events\Dispatcher;

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
     * The event dispatcher.
     *
     * @var Dispatcher
     */
    protected $events;

    /**
     * The module collection.
     *
     * @var ModuleCollection
     */
    protected $modules;

    /**
     * The resolver utility.
     *
     * @var Resolver
     */
    protected $resolver;

    /**
     * Create a new ShortcutHandler instance.
     *
     * @param Dispatcher $events
     * @param ModuleCollection $modules
     * @param Resolver $resolver
     */
    public function __construct(Dispatcher $events, ModuleCollection $modules, Resolver $resolver)
    {
        $this->events   = $events;
        $this->modules  = $modules;
        $this->resolver = $resolver;
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
        foreach ($this->modules as $module) {

            $shortcuts = $module->getShortcuts();

            if ($shortcuts && is_array($shortcuts)) {
                $builder->addShortcuts($module->getShortcuts());
            }

            if ($shortcuts && is_string($shortcuts)) {
                $this->resolver->resolve($shortcuts . '@handle', compact('builder'));
            }

            /*
             * If the module has a shortcuts handler
             * let that HANDLE the shortcuts.
             */
            if (!$shortcuts && class_exists($shortcuts = get_class($module) . 'Shortcuts')) {
                $this->resolver->resolve($shortcuts . '@handle', compact('builder'));
            }
        }

        $this->events->dispatch(new GatherShortcuts($builder));
    }
}

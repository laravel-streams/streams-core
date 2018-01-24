<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Support\Resolver;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Event\GatherSections;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;
use Illuminate\Contracts\Events\Dispatcher;

/**
 * Class SectionHandler
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SectionHandler
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
     * Create a new SectionHandler instance.
     *
     * @param Dispatcher       $events
     * @param ModuleCollection $modules
     * @param Resolver         $resolver
     */
    public function __construct(Dispatcher $events, ModuleCollection $modules, Resolver $resolver)
    {
        $this->events   = $events;
        $this->modules  = $modules;
        $this->resolver = $resolver;
    }

    /**
     * Handle the sections.
     *
     * @param ControlPanelBuilder $builder
     */
    public function handle(ControlPanelBuilder $builder)
    {

        /**
         * Start off with no
         * sections for now.
         */
        $builder->setSections([]);

        /*
         * We have to have a module for
         * the default functionality.
         *
         * Set your own sections
         * prior if needed!
         */
        if (!$module = $this->modules->active()) {

            $this->events->fire(new GatherSections($builder));

            return;
        }

        /*
         * Default to the module's sections.
         */
        $builder->setSections($sections = $module->getSections());

        /*
         * If the module has a sections handler
         * let that HANDLE the sections.
         */
        if (!$sections && class_exists($sections = get_class($module) . 'Sections')) {
            $this->resolver->resolve($sections . '@handle', compact('builder'));
        }

        $this->events->fire(new GatherSections($builder));
    }
}

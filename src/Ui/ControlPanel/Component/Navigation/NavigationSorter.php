<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation;

use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation\Event\SortNavigation;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;
use Illuminate\Contracts\Events\Dispatcher;

/**
 * Class NavigationSorter
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class NavigationSorter
{

    /**
     * The event dispatcher.
     *
     * @var Dispatcher
     */
    protected $events;

    /**
     * Create a new NavigationSorter instance.
     *
     * @param Dispatcher $events
     */
    public function __construct(Dispatcher $events)
    {
        $this->events = $events;
    }

    /**
     * Create a new NavigationSorter instance.
     *
     * @param ControlPanelBuilder $builder
     */
    public function sort(ControlPanelBuilder $builder)
    {
        if (!$navigation = $builder->getNavigation()) {
            return;
        }

        ksort($navigation);

        /**
         * Make the namespaces the key now
         * that we've applied default sorting.
         */
        $navigation = array_combine(
            array_map(
                function ($item) {
                    return $item['slug'];
                },
                $navigation
            ),
            array_values($navigation)
        );

        /**
         * Again by default push the dashboard
         * module to the top of the navigation.
         */
        foreach ($navigation as $key => $module) {

            if ($key == 'anomaly.module.dashboard') {

                $navigation = [$key => $module] + $navigation;

                break;
            }
        }

        $builder->setNavigation($navigation);

        $this->events->fire(new SortNavigation($builder));
    }
}

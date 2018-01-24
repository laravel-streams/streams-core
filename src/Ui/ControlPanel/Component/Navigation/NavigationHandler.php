<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation;

use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation\Event\GatherNavigation;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;
use Illuminate\Contracts\Events\Dispatcher;

/**
 * Class NavigationHandler
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class NavigationHandler
{

    /**
     * Handle the navigation.
     *
     * @param ControlPanelBuilder $builder
     * @param ModuleCollection    $modules
     * @param Dispatcher          $events
     */
    public function handle(ControlPanelBuilder $builder, ModuleCollection $modules, Dispatcher $events)
    {
        $navigation = [];

        /* @var Module $module */
        foreach ($modules->enabled()->accessible() as $module) {
            if ($module->getNavigation()) {
                $navigation[$module->getSlug()] = $module;
            }
        }

        $builder->setNavigation(
            array_map(
                function (Module $module) {
                    return [
                        'breadcrumb' => $module->getName(),
                        'icon'       => $module->getIcon(),
                        'title'      => $module->getTitle(),
                        'slug'       => $module->getNamespace(),
                        'href'       => 'admin/' . $module->getSlug(),
                    ];
                },
                $navigation
            )
        );

        $events->fire(new GatherNavigation($builder));
    }
}

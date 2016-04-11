<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation;

use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class NavigationHandler
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation
 */
class NavigationHandler implements SelfHandling
{

    /**
     * Handle the navigation.
     *
     * @param ControlPanelBuilder $builder
     * @param ModuleCollection    $modules
     */
    public function handle(ControlPanelBuilder $builder, ModuleCollection $modules)
    {
        $navigation = [];

        /* @var Module $module */
        foreach ($modules->enabled()->accessible() as $module) {
            if ($module->getNavigation()) {
                $navigation[trans($module->getName())] = $module;
            }
        }

        ksort($navigation);

        foreach ($navigation as $key => $module) {
            if ($module->getNamespace() == 'anomaly.module.dashboard') {

                $navigation = [$key => $module] + $navigation;

                break;
            }
        }

        $builder->setNavigation(
            array_map(
                function (Module $module) {
                    return [
                        'breadcrumb' => $module->getName(),
                        'title'      => $module->getTitle(),
                        'slug'       => $module->getNamespace(),
                        'href'       => 'admin/' . $module->getSlug(),
                    ];
                },
                $navigation
            )
        );
    }
}

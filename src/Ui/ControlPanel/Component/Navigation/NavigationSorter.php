<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation;

use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;

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
     * Create a new NavigationSorter instance.
     *
     * @param ControlPanelBuilder $builder
     */
    public function sort(ControlPanelBuilder $builder)
    {
        $navigation = $builder->getNavigation();

        ksort($navigation);

        foreach ($navigation as $key => $module) {

            if ($key == 'dashboard') {

                $navigation = [$key => $module] + $navigation;

                break;
            }
        }

        $builder->setNavigation($navigation);
    }
}

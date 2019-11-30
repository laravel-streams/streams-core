<?php

namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation;

use Anomaly\Streams\Platform\Ui\Support\Normalizer;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class NavigationInput
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class NavigationInput
{

    /**
     * The navigation sorter.
     *
     * @var NavigationSorter
     */
    protected $sorter;

    /**
     * Create a new NavigationInput instance.
     *
     * @param NavigationSorter     $sorter
     */
    public function __construct(
        NavigationSorter $sorter
    ) {
        $this->sorter     = $sorter;
    }

    /**
     * Read the navigation input.
     *
     * @param ControlPanelBuilder $builder
     */
    public function read(ControlPanelBuilder $builder)
    {
        $navigation = $builder->getNavigation();

        $navigation = resolver($navigation, compact('builder'));

        $navigation = $navigation ?: $builder->getNavigation();

        Normalizer::navigation($navigation);
        Normalizer::attributes($navigation);

        $navigation = evaluate($navigation, compact('builder'));

        $builder->setNavigation($navigation);

        $this->sorter->sort($builder);
    }
}

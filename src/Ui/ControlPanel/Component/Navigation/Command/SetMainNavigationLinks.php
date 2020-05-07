<?php

namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation\Command;

use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation\NavigationLink;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class SetMainNavigationLinks
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SetMainNavigationLinks
{

    /**
     * The control_panel builder.
     *
     * @var ControlPanelBuilder
     */
    protected $builder;

    /**
     * Create a new SetMainNavigationLinks instance.
     *
     * @param ControlPanelBuilder $builder
     */
    public function __construct(ControlPanelBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        $links = $this->builder->getControlPanelNavigation();

        $favorites = config('streams.navigation.favorites', []);

        /* @var NavigationLink $link */
        foreach ($links as $link) {
            $link->favorite = in_array($link->slug, $favorites);
        }
    }
}

<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation\Command;

use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation\Contract\NavigationLinkInterface;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;
use Illuminate\Contracts\Config\Repository;

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
     *
     * @param Repository $config
     */
    public function handle(Repository $config)
    {
        $links = $this->builder->getControlPanelNavigation();

        $favorites = $config->get('streams::navigation.favorites', []);

        /* @var NavigationLinkInterface $link */
        foreach ($links as $link) {
            $link->setFavorite(in_array($link->getSlug(), $favorites));
        }
    }
}

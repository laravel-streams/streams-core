<?php

namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation;

use Anomaly\Streams\Platform\Support\Facades\Hydrator;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation\Contract\NavigationLinkInterface;
use Illuminate\Contracts\Container\Container;

/**
 * Class NavigationFactory
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class NavigationFactory
{

    /**
     * The navigation link class.
     *
     * @var NavigationLink
     */
    protected $link = NavigationLink::class;

    /**
     * The service container.
     *
     * @var Container
     */
    protected $container;

    /**
     * Create a new NavigationFactory instance.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Make the navigation link.
     *
     * @param  array                   $parameters
     * @return NavigationLinkInterface
     */
    public function make(array $parameters)
    {
        $link = $this->container->make(array_get($parameters, 'link', $this->link), $parameters);

        Hydrator::hydrate($link, $parameters);

        return $link;
    }
}

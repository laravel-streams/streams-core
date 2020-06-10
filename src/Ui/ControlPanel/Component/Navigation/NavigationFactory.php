<?php

namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Anomaly\Streams\Platform\Support\Facades\Hydrator;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation\NavigationLink;

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
     * Make the navigation link.
     *
     * @param  array                   $parameters
     * @return NavigationLinkInterface
     */
    public function make(array $parameters)
    {
        $link = App::make(Arr::get($parameters, 'link', $this->link), $parameters);

        Hydrator::hydrate($link, $parameters);

        return $link;
    }
}

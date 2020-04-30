<?php

namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation\Contract;

use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\SectionCollection;

/**
 * Interface NavigationLinkInterface
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
/**
 * Interface NavigationLinkInterface
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
interface NavigationLinkInterface
{

    /**
     * Get the HREF attribute.
     *
     * @param  null   $path
     * @return string
     */
    public function getHref($path = null);
}

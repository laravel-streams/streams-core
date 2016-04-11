<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation;

use Anomaly\Streams\Platform\Support\Collection;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation\Contract\NavigationLinkInterface;

/**
 * Class NavigationCollection
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation
 */
class NavigationCollection extends Collection
{

    /**
     * Return the active link.
     *
     * @return null|NavigationLinkInterface
     */
    public function active()
    {
        /* @var NavigationLinkInterface $item */
        foreach ($this->items as $item) {
            if ($item->isActive()) {
                return $item;
            }
        }

        return null;
    }
}

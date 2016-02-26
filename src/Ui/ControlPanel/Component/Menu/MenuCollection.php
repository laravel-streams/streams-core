<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Menu;

use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Menu\Contract\MenuItemInterface;
use Illuminate\Support\Collection;

/**
 * Class MenuCollection
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\ControlPanel\Component\Menu
 */
class MenuCollection extends Collection
{

    /**
     * Return the active menu.
     *
     * @return null|MenuItemInterface
     */
    public function active()
    {
        /* @var MenuItemInterface $item */
        foreach ($this->items as $item) {
            if ($item->isActive()) {
                return $item;
            }
        }

        return null;
    }

    /**
     * Return only root menus.
     *
     * @return MenuCollection
     */
    public function root()
    {
        return self::make(
            array_filter(
                $this->all(),
                function (MenuItemInterface $menu) {
                    return $menu->getParent() === null;
                }
            )
        );
    }
}

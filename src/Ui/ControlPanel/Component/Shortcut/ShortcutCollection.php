<?php

namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Shortcut;

use Illuminate\Support\Collection;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Shortcut\Shortcut;

/**
 * Class ShortcutCollection
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ShortcutCollection extends Collection
{

    /**
     * Return the active shortcut.
     *
     * @return null|ShortcutInterface
     */
    public function active()
    {
        /* @var Shortcut $item */
        foreach ($this->items as $item) {
            if ($item->isActive()) {
                return $item;
            }
        }

        return null;
    }

    /**
     * Return only root shortcuts.
     *
     * @return ShortcutCollection
     */
    public function root()
    {
        return self::make(
            array_filter(
                $this->all(),
                function (Shortcut $shortcut) {
                    return !$shortcut->isSubShortcut();
                }
            )
        );
    }

    /**
     * Return only visible shortcuts.
     *
     * @return ShortcutCollection
     */
    public function visible()
    {
        return self::make(
            array_filter(
                $this->all(),
                function (Shortcut $shortcut) {
                    return !$shortcut->isHidden();
                }
            )
        );
    }

    /**
     * Return only shortcuts with parent.
     *
     * @param $parent
     * @return static
     */
    public function children($parent)
    {
        return self::make(
            array_filter(
                $this->all(),
                function (Shortcut $shortcut) use ($parent) {
                    return $shortcut->getParent() === $parent;
                }
            )
        );
    }
}

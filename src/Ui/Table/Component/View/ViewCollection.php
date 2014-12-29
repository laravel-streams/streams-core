<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\View;

use Anomaly\Streams\Platform\Ui\Table\Component\View\Contract\ViewInterface;
use Illuminate\Support\Collection;

/**
 * Class ViewCollection
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\View
 */
class ViewCollection extends Collection
{

    /**
     * Return the active view or null.
     *
     * @return null|ViewInterface
     */
    public function active()
    {
        foreach ($this->items as $item) {
            if ($item instanceof ViewInterface && $item->isActive()) {
                return $item;
            }
        }

        return null;
    }

    /**
     * Find a view by it's slug.
     *
     * @param $slug
     * @return null|ViewInterface
     */
    public function findBySlug($slug)
    {
        foreach ($this->items as $item) {
            if ($item instanceof ViewInterface && $item->getSlug() == $slug) {
                return $item;
            }
        }

        return null;
    }
}

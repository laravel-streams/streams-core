<?php namespace Anomaly\Streams\Platform\Ui\Table\View;

use Anomaly\Streams\Platform\Ui\Table\View\Contract\ViewInterface;
use Illuminate\Support\Collection;

/**
 * Class ViewCollection
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\View
 */
class ViewCollection extends Collection
{

    /**
     * Get the active view.
     *
     * @return ViewInterface|null
     */
    public function active()
    {
        foreach ($this->items as $item) {
            if ($this->viewIsActive($item)) {
                return $item;
            }
        }

        return null;
    }

    /**
     * Find a view by it's slug.
     *
     * @param  $slug
     * @return ViewInterface|null
     */
    public function findBySlug($slug)
    {
        foreach ($this->items as $item) {
            if ($this->viewSlugIs($item, $slug)) {
                return $item;
            }
        }

        return null;
    }

    /**
     * Return whether the view is active or not.
     *
     * @param  ViewInterface $item
     * @return mixed
     */
    protected function viewIsActive(ViewInterface $item)
    {
        return $item->isActive();
    }

    /**
     * Return whether the action slug matches the provided one.
     *
     * @param  ViewInterface $item
     * @param                $slug
     * @return bool
     */
    protected function viewSlugIs(ViewInterface $item, $slug)
    {
        return ($item->getSlug() == $slug);
    }
}

<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\View;

use Illuminate\Support\Collection;
use Anomaly\Streams\Platform\Ui\Table\Component\View\View;

/**
 * Class ViewCollection
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ViewCollection extends Collection
{

    /**
     * Return the active view or null.
     *
     * @return null|View
     */
    public function active()
    {
        return $this->first(function ($item) {
            return $item->active;
        });
    }

    /**
     * Find a view by it's slug.
     *
     * @param $slug
     * @return null|View
     */
    public function findBySlug($slug)
    {
        return $this->first(function ($item) use ($slug) {
            return $item->slug === $slug;
        });
    }
}

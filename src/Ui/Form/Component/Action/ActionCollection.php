<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Action;

use Anomaly\Streams\Platform\Ui\Button\ButtonCollection;

/**
 * Class ActionCollection
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ActionCollection extends ButtonCollection
{

    /**
     * Return the active action.
     *
     * @return null|Action
     */
    public function active()
    {
        return $this->first(function ($item) {
            return $item->active;
        });
    }

    /**
     * Find a action by it's slug.
     *
     * @param $slug
     * @return null|ActionInterface
     */
    public function findBySlug($slug)
    {
        return $this->first(function ($item) use ($slug) {
            return $item->slug == $slug;
        });
    }
}

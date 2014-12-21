<?php namespace Anomaly\Streams\Platform\Ui\Table\Action;

use Anomaly\Streams\Platform\Ui\Table\Action\Contract\ActionInterface;
use Illuminate\Support\Collection;

/**
 * Class ActionCollection
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Action
 */
class ActionCollection extends Collection
{

    /**
     * Return the active table action.
     *
     * @return ActionInterface|null
     */
    public function active()
    {
        foreach ($this->items as $item) {
            if ($item->isActive()) {
                return $item;
            }
        }

        return null;
    }

    /**
     * Find an action by it's slug.
     *
     * @param  $slug
     * @return ActionInterface|null
     */
    public function findBySlug($slug)
    {
        foreach ($this->items as $item) {
            if ($item->getSlug() == $slug) {
                return $item;
            }
        }

        return null;
    }
}

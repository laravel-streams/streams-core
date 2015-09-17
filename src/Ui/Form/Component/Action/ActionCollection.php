<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Action;

use Anomaly\Streams\Platform\Ui\Form\Component\Action\Contract\ActionInterface;
use Illuminate\Support\Collection;

/**
 * Class ActionCollection.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Action
 */
class ActionCollection extends Collection
{
    /**
     * Return the active action or null.
     *
     * @return null|ActionInterface
     */
    public function active()
    {
        foreach ($this->items as $item) {
            if ($item instanceof ActionInterface && $item->isActive()) {
                return $item;
            }
        }

        return;
    }

    /**
     * Find a action by it's slug.
     *
     * @param $slug
     * @return null|ActionInterface
     */
    public function findBySlug($slug)
    {
        foreach ($this->items as $item) {
            if ($item instanceof ActionInterface && $item->getSlug() == $slug) {
                return $item;
            }
        }

        return;
    }
}

<?php namespace Anomaly\Streams\Platform\Ui\Table\Action;

use Anomaly\Streams\Platform\Ui\Table\Action\Contract\ActionInterface;
use Illuminate\Support\Collection;

/**
 * Class ActionCollection
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Action
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
            if ($this->actionIsActive($item)) {
                return $item;
            }
        }

        return null;
    }

    /**
     * Find an action by it's slug.
     *
     * @param $slug
     * @return null
     */
    public function findBySlug($slug)
    {
        foreach ($this->items as $item) {
            if ($this->actionSlugIs($item, $slug)) {
                return $item;
            }
        }

        return null;
    }

    /**
     * Return whether the action is active or not.
     *
     * @param Action $item
     * @return bool
     */
    protected function actionIsActive(ActionInterface $item)
    {
        return $item->isActive();
    }

    /**
     * Return whether the action slug matches the provided one.
     *
     * @param ActionInterface $item
     * @param                 $slug
     * @return bool
     */
    protected function actionSlugIs(ActionInterface $item, $slug)
    {
        return ($item->getSlug() == $slug);
    }
}

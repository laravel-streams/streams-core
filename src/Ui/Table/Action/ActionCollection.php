<?php namespace Anomaly\Streams\Platform\Ui\Table\Action;

use Anomaly\Streams\Platform\Ui\Form\Action\Action;
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
     * Return whether the action is active or not.
     *
     * @param Action $item
     * @return bool
     */
    protected function actionIsActive(Action $item)
    {
        return $item->isActive();
    }
}

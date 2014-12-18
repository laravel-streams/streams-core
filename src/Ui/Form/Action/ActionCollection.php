<?php namespace Anomaly\Streams\Platform\Ui\Form\Action;

use Anomaly\Streams\Platform\Ui\Form\Action\Contract\ActionInterface;
use Illuminate\Support\Collection;

/**
 * Class ActionCollection
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Form\Action
 */
class ActionCollection extends Collection
{

    /**
     * Return the active action.
     *
     * @return null
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
     * @param  ActionInterface $item
     * @return mixed
     */
    protected function actionIsActive(ActionInterface $item)
    {
        return $item->isActive();
    }
}

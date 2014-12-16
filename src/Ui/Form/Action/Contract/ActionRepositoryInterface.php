<?php namespace Anomaly\Streams\Platform\Ui\Form\Action\Contract;

/**
 * Interface ActionRepositoryInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Action\Contract
 */
interface ActionRepositoryInterface
{

    /**
     * Find an action.
     *
     * @param $action
     * @return mixed
     */
    public function find($action);
}

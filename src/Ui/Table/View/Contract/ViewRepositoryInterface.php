<?php namespace Anomaly\Streams\Platform\Ui\Table\View\Contract;

/**
 * Interface ViewRepositoryInterface
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\View\Contract
 */
interface ViewRepositoryInterface
{

    /**
     * Find a view.
     *
     * @param  $view
     * @return mixed
     */
    public function find($view);
}

<?php namespace Anomaly\Streams\Platform\Contract;

/**
 * Interface PresentableInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Contract
 */
interface PresentableInterface
{
    /**
     * Return a new presenter object.
     *
     * @return mixed
     */
    public function newPresenter();
}

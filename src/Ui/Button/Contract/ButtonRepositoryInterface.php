<?php namespace Anomaly\Streams\Platform\Ui\Button\Contract;

/**
 * Interface ButtonRepositoryInterface
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Button\Contract
 */
interface ButtonRepositoryInterface
{

    /**
     * Find a button.
     *
     * @param  $button
     * @return mixed
     */
    public function find($button);
}

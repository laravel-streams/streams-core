<?php namespace Anomaly\Streams\Platform\Contract;

/**
 * Interface ArrayableInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Contract
 */
interface ArrayableInterface
{

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray();
}

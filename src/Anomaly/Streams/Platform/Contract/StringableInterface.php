<?php namespace Anomaly\Streams\Platform\Contract;

/**
 * Interface StringableInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Contract
 */
interface StringableInterface
{
    /**
     * Return the instance as a string.
     *
     * @return mixed
     */
    public function toString();
}

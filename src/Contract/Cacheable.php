<?php namespace Anomaly\Streams\Platform\Contract;

/**
 * Interface Cacheable
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Contract
 */
interface Cacheable
{

    /**
     * Get the cache collection key.
     *
     * @return mixed
     */
    public function getCacheCollectionKey();

    /**
     * Get the minutes to cache for.
     *
     * @return mixed
     */
    public function getCacheMinutes();
}

<?php namespace Anomaly\Streams\Platform\Contract;

/**
 * Class TranslatableInterface
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Contract
 */
interface TranslatableInterface
{

    /**
     * Return the model translation.
     *
     * @param null $locale
     * @param bool $withFallback
     */
    public function translate($locale = null, $withFallback = false);
}

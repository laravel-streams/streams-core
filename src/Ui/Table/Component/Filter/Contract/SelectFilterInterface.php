<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract;

/**
 * Interface SelectFilterInterface.
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract
 */
interface SelectFilterInterface extends FilterInterface
{
    /**
     * Set the options.
     *
     * @param  array $options
     * @return mixed
     */
    public function setOptions(array $options);

    /**
     * Get the options.
     *
     * @return mixed
     */
    public function getOptions();
}

<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract;

/**
 * Interface InputFilterInterface.
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract
 */
interface InputFilterInterface extends FilterInterface
{
    /**
     * Set the type.
     *
     * @param  $type
     * @return mixed
     */
    public function setType($type);

    /**
     * Get the type.
     *
     * @return mixed
     */
    public function getType();
}

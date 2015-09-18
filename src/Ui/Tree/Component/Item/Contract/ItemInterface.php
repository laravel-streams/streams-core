<?php

namespace Anomaly\Streams\Platform\Ui\Tree\Component\Item\Contract;

/**
 * Interface ItemInterface.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Tree\Component\Item\Contract
 */
interface ItemInterface
{
    /**
     * Get the ID.
     *
     * @return int
     */
    public function getId();

    /**
     * Get the parent ID.
     *
     * @return int
     */
    public function getParent();
}

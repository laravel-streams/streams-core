<?php namespace Anomaly\Streams\Platform\Ui\Tree\Component\Item\Contract;

/**
 * Interface ItemInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Tree\Component\Item\Contract
 */
interface ItemInterface
{

    /**
     * Return the root flag.
     *
     * @return bool
     */
    public function isRoot();

    /**
     * Get the parent ID.
     *
     * @return int
     */
    public function getParentId();

    /**
     * Get the entry ID.
     *
     * @return int
     */
    public function getEntryId();
}

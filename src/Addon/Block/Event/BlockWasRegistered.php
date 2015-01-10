<?php namespace Anomaly\Streams\Platform\Addon\Block\Event;

use Anomaly\Streams\Platform\Addon\Block\Block;

/**
 * Class BlockWasRegistered
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Block\Event
 */
class BlockWasRegistered
{

    /**
     * The block object.
     *
     * @var Block
     */
    protected $block;

    /**
     * Create a new BlockWasRegistered instance.
     *
     * @param Block $block
     */
    public function __construct(Block $block)
    {
        $this->block = $block;
    }

    /**
     * Get the block object.
     *
     * @return Block
     */
    public function getBlock()
    {
        return $this->block;
    }
}

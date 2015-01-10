<?php namespace Anomaly\Streams\Platform\Addon\Block\Listener;

use Anomaly\Streams\Platform\Addon\Block\BlockCollection;
use Anomaly\Streams\Platform\Addon\Block\Event\BlockWasRegistered;

/**
 * Class PutBlockInCollection
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Block\Listener
 */
class PutBlockInCollection
{

    /**
     * The block collection.
     *
     * @var BlockCollection
     */
    protected $blocks;

    /**
     * Create a new PutBlockInCollection instance.
     *
     * @param BlockCollection $blocks
     */
    public function __construct(BlockCollection $blocks)
    {
        $this->blocks = $blocks;
    }

    /**
     * Handle the event.
     *
     * @param BlockWasRegistered $event
     */
    public function handle(BlockWasRegistered $event)
    {
        $block = $event->getBlock();

        $this->blocks->put(get_class($block), $block);
    }
}

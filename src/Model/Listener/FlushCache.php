<?php namespace Anomaly\Streams\Platform\Model\Listener;

use Anomaly\Streams\Platform\Collection\CacheCollection;
use Anomaly\Streams\Platform\Model\Event\ModelWasCreated;

/**
 * Class FlushCache
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Model\Listener
 */
class FlushCache
{

    /**
     * Handle the event.
     *
     * @param ModelWasCreated $event
     */
    public function handle($event)
    {
        (new CacheCollection())->setKey($event->getModel()->getCacheCollectionKey())->flush();
    }
}

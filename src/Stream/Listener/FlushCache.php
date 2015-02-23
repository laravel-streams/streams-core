<?php namespace Anomaly\Streams\Platform\Stream\Listener;

/**
 * Class FlushCache
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Stream\Listener
 */
class FlushCache
{

    /**
     * Handle the event.
     */
    public function handle()
    {
        app('cache')->flush();
    }
}

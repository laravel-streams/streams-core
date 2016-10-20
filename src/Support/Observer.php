<?php namespace Anomaly\Streams\Platform\Support;

use Anomaly\Streams\Platform\Traits\FiresCallbacks;
use Illuminate\Contracts\Bus\Dispatcher as CommandDispatcher;
use Illuminate\Contracts\Events\Dispatcher as EventDispatcher;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class Observer
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Observer
{
    use FiresCallbacks;
    use DispatchesJobs;

    /**
     * The event dispatcher.
     *
     * @var EventDispatcher
     */
    protected $events;

    /**
     * The command dispatcher.
     *
     * @var CommandDispatcher
     */
    protected $commands;

    /**
     * Create a new EloquentObserver instance.
     *
     * @param EventDispatcher   $events
     * @param CommandDispatcher $commands
     */
    public function __construct(EventDispatcher $events, CommandDispatcher $commands)
    {
        $this->events   = $events;
        $this->commands = $commands;
    }
}

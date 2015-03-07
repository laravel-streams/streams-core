<?php namespace Anomaly\Streams\Platform\Http\Middleware;

use Anomaly\Streams\Platform\Application\Event\ApplicationHasLoaded;
use Closure;
use Illuminate\Events\Dispatcher;
use Illuminate\Http\Request;

/**
 * Class ApplicationReady
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Http\Middleware
 */
class ApplicationReady
{

    /**
     * @var Dispatcher
     */
    protected $events;

    /**
     * Create a new ApplicationReady instance.
     *
     * @param Dispatcher $events
     */
    public function __construct(Dispatcher $events)
    {
        $this->events = $events;
    }

    /**
     * Fire an event here as we enter the middleware
     * layer of the application so we can hook into it.
     *
     * @param  Request  $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $this->events->fire(new ApplicationHasLoaded());

        return $next($request);
    }
}

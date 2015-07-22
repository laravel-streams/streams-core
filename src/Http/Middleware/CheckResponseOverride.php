<?php namespace Anomaly\Streams\Platform\Http\Middleware;

use Anomaly\Streams\Platform\Http\Routing\StreamsResponse;
use Closure;
use Illuminate\Http\Request;

/**
 * Class CheckResponseOverride
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Http\Middleware
 */
class CheckResponseOverride
{

    /**
     * The override instance.
     *
     * @var StreamsResponse
     */
    protected $override;

    /**
     * Create a new CheckResponseOverride instance.
     *
     * @param StreamsResponse $override
     */
    public function __construct(StreamsResponse $override)
    {
        $this->override = $override;
    }

    /**
     * Check for a response override.
     *
     * @param  Request  $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($this->override->exists()) {
            return $this->override->getResponse();
        }

        return $response;
    }
}

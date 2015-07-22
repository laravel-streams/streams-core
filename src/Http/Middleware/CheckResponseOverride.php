<?php namespace Anomaly\Streams\Platform\Http\Middleware;

use Anomaly\Streams\Platform\Http\Routing\ResponseOverride;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

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
     * @var ResponseOverride
     */
    protected $override;

    /**
     * Create a new CheckResponseOverride instance.
     *
     * @param ResponseOverride $override
     */
    public function __construct(ResponseOverride $override)
    {
        $this->override = $override;
    }

    /**
     * Check for a response override.
     *
     * @param  Request  $request
     * @param  \Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next)
    {
        // This is the original.
        $response = $next($request);

        /**
         * If an override is present then
         * send it instead of the original.
         */
        if ($this->override->exists()) {
            return $this->override->get();
        }

        return $response;
    }
}

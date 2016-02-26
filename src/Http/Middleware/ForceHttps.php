<?php namespace Anomaly\Streams\Platform\Http\Middleware;

use Closure;
use Illuminate\Config\Repository;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

/**
 * Class ForceHttps
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Http\Middleware
 */
class ForceHttps
{

    /**
     * The config repository.
     *
     * @var Repository
     */
    protected $config;

    /**
     * The redirector.
     *
     * @var Redirector
     */
    protected $redirector;

    /**
     * Create a new ForceHttps instance.
     *
     * @param Repository $config
     * @param Redirector $redirector
     */
    public function __construct(Repository $config, Redirector $redirector)
    {
        $this->config     = $config;
        $this->redirector = $redirector;
    }

    /**
     * Determine if we need to force HTTPS
     * based on setting value.
     *
     * @param  Request  $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $forceHttps = $this->config->get('streams::access.force_https', 'none');

        /**
         * Don't force HTTPS at all.
         */
        if ($forceHttps == 'none') {
            return $next($request);
        }

        /**
         * Force all connections through HTTPS.
         */
        if ($forceHttps == 'all' && !$request->isSecure()) {
            return $this->redirector->secure($request->path());
        }

        /**
         * Only force public access through HTTPS.
         */
        if ($forceHttps == 'public' && !$request->isSecure() && $request->segment(1) !== 'admin') {
            return $this->redirector->secure($request->path());
        }

        /**
         * Only force admin access through HTTPS.
         */
        if ($forceHttps == 'admin' && !$request->isSecure() && $request->segment(1) == 'admin') {
            return $this->redirector->secure($request->path());
        }

        // Default to whatever.
        return $next($request);
    }
}

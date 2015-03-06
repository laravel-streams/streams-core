<?php namespace Anomaly\Streams\Platform\Http\Middleware;

use Closure;
use Illuminate\Config\Repository;
use Illuminate\Http\Request;

/**
 * Class CheckSiteStatus
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Http\Middleware
 */
class CheckSiteStatus
{

    /**
     * The config repository.
     *
     * @var Repository
     */
    protected $config;

    /**
     * Create a new CheckSiteStatus instance.
     *
     * @param Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->config = $config;
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
        $enabled = $this->config->get('streams.site_enabled', true);

        /**
         * Continue on if we're enabled.
         */
        if ($enabled) {
            return $next($request);
        }

        /**
         * Continue on if we're in admin.
         */
        if ($request->segment(1) == 'admin') {
            return $next($request);
        }

        /**
         * If we're disabled then we need to abort.
         */
        if (!in_array($request->getClientIp(), $this->config->get('streams.ip_whitelist', []))) {
            return response()->view('streams::errors/503', [], 503);
        }

        return $next($request);
    }
}

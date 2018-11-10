<?php namespace Anomaly\Streams\Platform\Http\Middleware;

use Closure;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Route;

class HttpCache
{

    /**
     * The config repository.
     *
     * @var Repository
     */
    protected $config;

    /**
     * Create a new PoweredBy instance.
     *
     * @param Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    /**
     * Say it loud.
     *
     * @param  Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        /* @var Response $response */
        $response = $next($request);

        /* @var Route $route */
        $route = $request->route();

        /**
         * Don't cache the admin.
         */
        if ($request->segment(1) == 'admin') {
            return $response;
        }

        /**
         * Don't cache if HTTP cache
         * is disabled in the route.
         */
        if ($route->getAction('streams::http_cache') === false) {
            return $response;
        }

        $response->setTtl($route->getAction('streams::http_cache') ?: 30);

        return $response;
    }

}

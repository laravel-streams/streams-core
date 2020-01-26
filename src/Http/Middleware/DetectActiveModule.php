<?php

namespace Anomaly\Streams\Platform\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Anomaly\Streams\Platform\Image\Image;

/**
 * Class DetectActiveModule
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class DetectActiveModule
{

    /**
     * Force SSL connections.
     *
     * @param  Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        /**
         * In order to detect we MUST have a route
         * and we MUST have a namespace in the
         * streams::addon action parameter.
         *
         * @var Route $route
         */
        if (!$route = $request->route()) {
            return $next($request);
        }

        /**
         * Pull the addon namespace
         * out of the route action.
         */
        $detected = array_get($route->getAction(), 'streams::addon');

        /* @var Module $module */
        if ($detected && $module = app('module.collection')->get($detected)) {
            app('module.collection')->setActive($detected);
        }

        // if (
        //     !$detected
        //     && $request->segment(1) == 'admin'
        //     && $module = app('module.collection')->findBySlug(
        //         $request->segment(2)
        //     )
        // ) {
        //     app('module.collection')->setActive($module['namespace']);
        // }

        if (!$detected) {
            return $next($request);
        }

        $path = base_path('vendor' . DIRECTORY_SEPARATOR . $module['name']);

        $resources = $path . DIRECTORY_SEPARATOR . 'resources';

        app('view')->addNamespace(
            'module',
            [
                $resources . DIRECTORY_SEPARATOR . 'views'
            ]
        );
        app('translator')->addNamespace('module', $resources . DIRECTORY_SEPARATOR . 'lang');

        assets()->addPath('module', $resources);
        app(Image::class)->addPath('module', $resources);

        return $next($request);
    }
}

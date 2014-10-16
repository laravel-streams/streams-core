<?php namespace Streams\Platform\Http\Middleware;

use Illuminate\Http\Request;

class InstallerMiddleware
{
    /**
     * Redirect to the installer if the
     * application is not installed.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function handle(Request $request, \Closure $next)
    {
        if ($request->segment(1) !== 'installer' and !app('streams.application')->isInstalled()) {
            return redirect('installer');
        }

        return $next($request);
    }
}

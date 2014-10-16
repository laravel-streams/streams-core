<?php namespace Streams\Platform\Http\Middleware;

class AuthMiddleware extends Middleware
{
    /**
     * Authorize the request.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function handle(Request $request, \Closure $next)
    {
        $request = app('request');
        $ignore  = array('login', 'logout');

        if (!in_array($request->segment(2), $ignore) and !app('auth')->check()) {
            app('session')->put('url.intended', $request->url());

            return redirect('admin/login');
        }

        return $next($request);
    }
}

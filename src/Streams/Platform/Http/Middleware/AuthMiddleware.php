<?php namespace Streams\Platform\Http\Middleware;

use Illuminate\Contracts\Routing\Middleware;

class AuthMiddleware extends Middleware
{
    public function handle($request, \Closure $next)
    {
        $ignore = array('login', 'logout');

        if (!in_array($request->segment(2), $ignore) and !app('auth')->check()) {
            app('session')->put('url.intended', $request->url());

            return redirect('admin/login');
        }

        return $next($request);
    }
}

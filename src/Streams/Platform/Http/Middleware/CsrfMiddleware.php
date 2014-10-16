<?php namespace Streams\Platform\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;

class CsrfMiddleware
{
    /**
     * Run the request filter.
     *
     * @throws \Illuminate\Session\TokenMismatchException
     */
    public function handle(Request $request, \Closure $next)
    {
        if (app('session')->token() != $request->input('_token')) {
            throw new TokenMismatchException;
        }

        return $next($request);
    }
}

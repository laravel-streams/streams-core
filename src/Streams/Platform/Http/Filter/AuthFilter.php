<?php namespace Streams\Platform\Http\Filter;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class AuthFilter
{
    /**
     * Authorize the request.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function filter()
    {
        $request = app('request');
        $ignore  = array('login', 'logout');

        if (!in_array($request->segment(2), $ignore) and !app('auth')->check()) {
            app('session')->put('url.intended', $request->url());

            return redirect('admin/login');
        }
    }
}

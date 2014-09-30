<?php namespace Streams\Platform\Http\Filter;

class AuthFilter
{
    /**
     * Authorize the request.
     *
     * @return mixed
     */
    public function filter()
    {
        $auth    = app('auth');
        $session = app('session');
        $request = app('request');

        $ignore = array('login', 'logout');

        if (!in_array($request->segment(2), $ignore) and !$auth->check()) {
            $session->put('url.intended', $request->url());

            return redirect('admin/login');
        }
    }
}

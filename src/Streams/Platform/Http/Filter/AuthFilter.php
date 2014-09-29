<?php namespace Streams\Platform\Http\Filter;

class AuthFilter
{

    /**
     * Run the request filter.
     *
     * @return mixed
     */
    public function filter()
    {
        $ignore = array('login', 'logout');

        if (\Application::boot() and !in_array(\Request::segment(2), $ignore) and !\Sentry::check()) {

            \Session::put('url.intended', \Request::url());

            return \Redirect::to('admin/login');
        }
    }

}

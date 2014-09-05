<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(
    function () {
        \Event::fire('app.before');

        if (\Request::segment(1) !== 'installer') {
            if (\Application::isInstalled()) {
                \Application::boot();
            } else {
                return \Redirect::to('installer');
            }
        }

        \Event::fire('app.booted');
    }
);


App::after(
    function ($request, $response) {
        \Event::fire('app.after', compact('request', 'response'));
    }
);


/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

// Authentication Filter
Route::filter(
    'authenticate',
    function () {
        $ignore = array('login', 'logout');

        if (!in_array(Request::segment(2), $ignore) and !Sentry::check()) {
            Session::put('url.intended', Request::url());
            return Redirect::to('admin/login');
        }
    }
);

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter(
    'csrf',
    function () {
        if (Session::token() != Input::get('_token')) {
            throw new Illuminate\Session\TokenMismatchException;
        }
    }
);

<?php

// Authenticate anything behind admin/
Route::when('admin*', 'auth');

// Login routes
Route::get('admin/login', 'Streams\Platform\Http\Controller\AdminController@login');
Route::post('admin/login', 'Streams\Platform\Http\Controller\AdminController@attemptLogin');

Route::get('admin/addons/modules', 'Streams\Addon\Module\Addons\Controller\Admin\ModulesController@index');
Route::get('admin/addons/modules/create', 'Streams\Addon\Module\Addons\Controller\Admin\ModulesController@create');
Route::get('admin/addons/modules/edit/{id}', 'Streams\Addon\Module\Addons\Controller\Admin\ModulesController@edit');
Route::post('admin/addons/modules/edit/{id}', 'Streams\Addon\Module\Addons\Controller\Admin\ModulesController@edit');

// Logout route
Route::get(
    'admin/logout',
    function () {
        Sentry::logout();
        return Redirect::to('admin/login');
    }
);

// Default module
Route::get(
    'admin',
    function () {
        return Redirect::to('admin/dashboard');
    }
);

// Installer loads from distribution
app()->make('streams.distributions')->find('base');
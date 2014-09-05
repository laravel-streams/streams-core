<?php

// Admin Routes
Route::when('admin*', 'authenticate'); // Authenticate anything admin

// Login routes
Route::get('admin/login', 'Streams\Core\Controller\AdminController@login');
Route::post('admin/login', 'Streams\Core\Controller\AdminController@attemptLogin');

// Logout logic
Route::get(
    'admin/logout',
    function () {
        Sentry::logout();
        return Redirect::to('admin/login');
    }
);

// Default module is the dashboard
Route::get(
    'admin',
    function () {
        return Redirect::to('admin/dashboard');
    }
);

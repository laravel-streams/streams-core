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










// Go to modules by default
Route::get(
    'admin/addons',
    function () {
        return Redirect::to('admin/addons/modules');
    }
);

crud('admin/addons/tags', 'Streams\Addon\Module\Addons\Controller\Admin\TagsController');
crud('admin/addons/blocks', 'Streams\Addon\Module\Addons\Controller\Admin\BlocksController');
crud('admin/addons/themes', 'Streams\Addon\Module\Addons\Controller\Admin\ThemesController');
crud('admin/addons/modules', 'Streams\Addon\Module\Addons\Controller\Admin\ModulesController');
crud('admin/addons/extensions', 'Streams\Addon\Module\Addons\Controller\Admin\ExtensionsController');
crud('admin/addons/field_types', 'Streams\Addon\Module\Addons\Controller\Admin\FieldTypesController');

// Install an addon
Route::get(
    'admin/addons/installer/install/{type}/{slug}',
    'Streams\Addon\Module\Addons\Controller\Admin\InstallerController@install'
);

Route::get(
    'admin/addons/installer/uninstall/{type}/{slug}',
    'Streams\Addon\Module\Addons\Controller\Admin\InstallerController@uninstall'
);
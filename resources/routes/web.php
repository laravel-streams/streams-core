<?php

use Illuminate\Support\Facades\Route;

Route::post(
    'form/handle/{key}',
    'Anomaly\Streams\Platform\Http\Controller\FormController@handle'
);

Route::get(
    'entry/handle/restore/{addon}/{stream}/{id}',
    'Anomaly\Streams\Platform\Http\Controller\EntryController@restore'
);

Route::get(
    'entry/handle/export/{addon}/{stream}',
    'Anomaly\Streams\Platform\Http\Controller\EntryController@export'
);

Route::get(
    'locks/touch',
    'Anomaly\Streams\Platform\Http\Controller\LocksController@touch'
);

Route::get(
    'locks/release',
    'Anomaly\Streams\Platform\Http\Controller\LocksController@release'
);

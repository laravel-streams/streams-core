<?php

use Illuminate\Support\Facades\Route;

Route::get(
    'entry/handle/restore/{addon}/{stream}/{id}',
    'Anomaly\Streams\Platform\Http\Controller\EntryController@restore'
);

Route::get(
    'entry/handle/export/{addon}/{stream}',
    'Anomaly\Streams\Platform\Http\Controller\EntryController@export'
);

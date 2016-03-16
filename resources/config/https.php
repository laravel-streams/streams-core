<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Redirect to HTTPS / HTTP
    |--------------------------------------------------------------------------
    |
    | Redirect to HTTP or HTTPS if conditions are met.
    |
    | Available options are null (no change), true (always redirect),
    | false (redirect to HTTP), or an array of URIs to redirect on.
    | Closures that return any available option may also .
    |
    */

    'redirect' => env('HTTPS_REDIRECT')

];

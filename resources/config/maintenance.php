<?php

return [

    /*
    |--------------------------------------------------------------------------
    | IP Whitelist
    |--------------------------------------------------------------------------
    |
    | If the site is disabled, only these IPs will be allowed to view public
    | facing content.
    |
    | NOTE: This configuration may be overridden by the Settings module.
    |
    */

    'ip_whitelist' => explode(',', env('IP_WHITELIST'))

];

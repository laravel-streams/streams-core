<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Site Enabled
    |--------------------------------------------------------------------------
    |
    | This controls whether the site is enabled to the public or not. When the
    | site is disabled you may only access the frontend if you are in the IP
    | white-list.
    |
    | NOTE: This configuration may be overridden by the Settings module.
    |
    */

    'site_enabled' => env('SITE_ENABLED', true),

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

    'ip_whitelist' => explode(',', env('IP_WHITELIST')),

    /*
    |--------------------------------------------------------------------------
    | Force HTTPS
    |--------------------------------------------------------------------------
    |
    | You may opt to force an SSL connection when accessing the application.
    | Supported options are "none", "all", "public", "admin"
    |
    | NOTE: This configuration may be overridden by the Settings module.
    |
    */

    'force_https' => env('FORCE_HTTPS', 'none')
];

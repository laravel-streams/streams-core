<?php namespace Streams\Platform\Provider;

use Illuminate\Support\ServiceProvider;

class HelpersServiceProvider extends ServiceProvider
{
    /**
     * Register Streams helpers.
     */
    public function register()
    {
        // For now just include the helpers PHP file.
        require_once __DIR__ . '/../../../../resources/helpers.php';
    }
}

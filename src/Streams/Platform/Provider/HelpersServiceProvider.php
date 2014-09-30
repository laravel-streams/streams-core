<?php namespace Streams\Platform\Provider;

use Illuminate\Support\ServiceProvider;

class HelpersServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->includeHelpersFile();
    }

    /**
     * Include the helpers file.
     */
    protected function includeHelpersFile()
    {
        // For now just include the helpers PHP file.
        include __DIR__ . '/../../../../resources/helpers.php';
    }
}

<?php namespace Streams\Core\Provider;

use Illuminate\Support\ServiceProvider;
use Streams\Core\Support\Filesystem;

class FilesystemServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bindShared(
            'files',
            function () {
                return new Filesystem;
            }
        );
    }
}

<?php namespace Streams\Platform\Spec;

use Illuminate\Foundation\Application;

class Bootstrap
{
    public static function get()
    {
        $app = new Application();

        $app->register('Illuminate\Encryption\EncryptionServiceProvider');
        $app->register('Illuminate\Filesystem\FilesystemServiceProvider');
        $app->register('Illuminate\Foundation\Providers\FoundationServiceProvider');
        $app->register('Illuminate\Log\LogServiceProvider');

        return $app;
    }
}
 
<?php namespace Anomaly\Streams\Platform\Http\Command;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Filesystem\Filesystem;

/**
 * Class ClearHttpCache
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ClearHttpCache
{

    /**
     * Handle the command.
     *
     * @param Filesystem $files
     * @param Repository $config
     * @internal param Container $container
     */
    public function handle(Filesystem $files, Repository $config)
    {
        $files->cleanDirectory($config->get('httpcache.cache_dir', storage_path('httpcache')));
    }
}

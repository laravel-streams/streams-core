<?php namespace Anomaly\Streams\Platform\Stream\Command;

use Anomaly\Streams\Platform\Addon\Addon;
use Illuminate\Filesystem\Filesystem;

/**
 * Class GetUninstalledStreams
 *
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 * @author Denis Efremov <efremov.a.denis@gmail.com>
 *
 * @link   http://pyrocms.com/
 */
class GetUninstalledStreams
{

    /**
     * The stream addon.
     *
     * @var Addon
     */
    protected $addon;

    /**
     * Create a new GetUninstalledStreams instance.
     *
     * @param Addon $addon
     */
    public function __construct(Addon $addon)
    {
        $this->addon = $addon;
    }

    /**
     * Handle the command.
     *
     * @param  Filesystem         $filesystem
     * @return StreamCollection
     */
    public function handle(Filesystem $filesystem)
    {
        $path = $this->addon->getPath('src/');

        $folders = $filesystem->glob($path . '*', GLOB_ONLYDIR);

        $streams = array_where(
            $folders,
            function ($folder) use ($filesystem)
            {
                $name = $filesystem->basename($folder);

                if ($name == 'Test' || $name == 'Command' || $name == 'Http')
                {
                    return false;
                }

                if (!$filesystem->exists("{$folder}/{$name}Model.php"))
                {
                    return false;
                }

                return true;
            }
        );

        return array_map(
            function ($path) use ($filesystem)
            {
                return $filesystem->basename($path);
            },
            $streams
        );
    }
}

<?php namespace Anomaly\Streams\Platform\Application\Command\Handler;

use Illuminate\Filesystem\Filesystem;

/**
 * Class CheckDirectoryPermissionsHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Application\Command\Handler
 */
class CheckDirectoryPermissionsHandler
{

    /**
     * The file system utility.
     *
     * @var Filesystem
     */
    protected $files;

    /**
     * Create a new CheckDirectoryPermissionsHandler instance.
     *
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        $this->files = $files;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        $paths = [
            'public/assets',
            'public/assets/' . APP_REF,
            'storage'
        ];

        foreach ($paths as $path) {
            if (!$this->files->isWritable(base_path($path))) {
                die("chmod -R 775 " . base_path($path) . "\n");
            }
        }
    }
}

<?php namespace Anomaly\Streams\Platform\Application\Command\Handler;

use Anomaly\Streams\Platform\Application\Application;
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
     * The streams application.
     *
     * @var Application
     */
    protected $application;

    /**
     * Create a new CheckDirectoryPermissionsHandler instance.
     *
     * @param Filesystem  $files
     * @param Application $application
     */
    public function __construct(Filesystem $files, Application $application)
    {
        $this->files       = $files;
        $this->application = $application;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        $paths = [
            'public/assets',
            'public/assets/' . $this->application->getReference(),
            'storage'
        ];

        foreach ($paths as $path) {
            if ($this->files->exists(base_path($path)) && !$this->files->isWritable(base_path($path))) {
                die("Your {$path} path must be writable. Please run \"chmod -R 775 " . base_path($path) . "\"\n");
            }
        }
    }
}

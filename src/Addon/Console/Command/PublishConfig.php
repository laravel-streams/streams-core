<?php namespace Anomaly\Streams\Platform\Addon\Console\Command;

use Anomaly\Streams\Platform\Application\Application;
use Anomaly\Streams\Platform\Addon\Addon;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class PublishConfig
{
    /**
     * The addon instance.
     *
     * @var Addon
     */
    protected $addon;

    /**
     * Create a new PublishConfig instance.
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
     * @param  Filesystem  $filesystem
     * @param  Application $application
     * @return string
     */
    public function handle(Filesystem $filesystem, Application $application)
    {
        $destination = 'addons/' .
            $this->addon->getVendor() . '/' .
            $this->addon->getSlug() . '-' .
            $this->addon->getType() . '/config';

        $filesystem->copyDirectory(
            $this->addon->getPath('resources/config'),
            $application->getResourcesPath($destination)
        );
    }
}

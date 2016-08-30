<?php namespace Anomaly\Streams\Platform\Addon\Console\Command;

use Anomaly\Streams\Platform\Application\Application;
use Anomaly\Streams\Platform\Addon\Addon;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\Command;

class PublishConfig
{
    /**
     * The addon instance.
     *
     * @var Addon
     */
    protected $addon;

    /**
     * The console command.
     *
     * @var Command
     */
    protected $command;

    /**
     * Create a new PublishConfig instance.
     *
     * @param Addon   $addon
     * @param Command $command
     */
    public function __construct(Addon $addon, Command $command)
    {
        $this->addon   = $addon;
        $this->command = $command;
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
        $destination = $application->getResourcesPath(
            'addons/' .
                $this->addon->getVendor() . '/' .
                $this->addon->getSlug() . '-' .
                $this->addon->getType() . '/config'
            );

        if (is_dir($destination) && !$this->command->option('force')) {
            return $this->command->error("$destination already exists.");
        }

        $filesystem->copyDirectory($this->addon->getPath('resources/config'), $destination);

        $this->command->info("Published $destination");
    }
}

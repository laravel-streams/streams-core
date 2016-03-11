<?php namespace Anomaly\Streams\Platform\Asset\Console;

use Anomaly\Streams\Platform\Application\Application;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

/**
 * Class Clear
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Stream\Console
 */
class Clear extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'assets:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear compiled public assets.';

    /**
     * Execute the console command.
     *
     * @param Filesystem  $files
     * @param Application $application
     */
    public function fire(Filesystem $files, Application $application)
    {
        $files->deleteDirectory($directory = $application->getAssetsPath(), true);

        $this->info($directory . ' has been emptied!');
    }
}

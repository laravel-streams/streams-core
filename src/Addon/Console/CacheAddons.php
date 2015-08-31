<?php namespace Anomaly\Streams\Platform\Addon\Console;

use Anomaly\Streams\Platform\Addon\AddonPaths;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class CacheAddons
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Console
 */
class CacheAddons extends Command
{

    use DispatchesJobs;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'addons:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cache addon directories.';

    /**
     * Execute the console command.
     *
     * @param AddonPaths $paths
     */
    public function fire(AddonPaths $paths)
    {
        $this->call('addons:clear');

        $path = base_path('bootstrap/cache/addons.php');

        if (file_exists($path)) {
            unlink($path);
        }

        $paths = var_export($paths->all(), true);

        file_put_contents($path, "<?php return {$paths};");

        $this->info('Addons cached successfully!');
    }
}

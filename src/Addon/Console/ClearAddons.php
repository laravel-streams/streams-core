<?php

namespace Anomaly\Streams\Platform\Addon\Console;

use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class ClearAddons.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Console
 */
class ClearAddons extends Command
{
    use DispatchesJobs;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'addons:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear cached addon directories.';

    /**
     * Execute the console command.
     */
    public function fire()
    {
        $path = base_path('bootstrap/cache/addons.php');

        if (file_exists($path)) {
            unlink($path);
        }

        $this->info('Addon cache cleared!');
    }
}

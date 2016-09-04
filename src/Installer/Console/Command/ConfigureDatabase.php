<?php namespace Anomaly\Streams\Platform\Installer\Console\Command;

use Anomaly\Streams\Platform\Application\Command\SetCoreConnection;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class ConfigureDatabase
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 */
class ConfigureDatabase
{
    use DispatchesJobs;

    /**
     * Handle the command.
     */
    public function handle()
    {
        config()->set('database', require base_path('config/database.php'));

        $this->dispatch(new SetCoreConnection());
    }
}

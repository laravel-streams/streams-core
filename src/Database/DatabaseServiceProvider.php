<?php namespace Anomaly\Streams\Platform\Database;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Support\ServiceProvider;

/**
 * Class DatabaseServiceProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Database
 */
class DatabaseServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register('Anomaly\Streams\Platform\Database\Seeder\SeederServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Database\Migration\MigrationServiceProvider');
    }
}

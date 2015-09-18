<?php

namespace Anomaly\Streams\Platform\Database\Migration;

use Anomaly\Streams\Platform\Database\Migration\Console\MigrateCommand;
use Anomaly\Streams\Platform\Database\Migration\Console\MigrateMakeCommand;
use Anomaly\Streams\Platform\Database\Migration\Console\RefreshCommand;
use Anomaly\Streams\Platform\Database\Migration\Console\ResetCommand;
use Illuminate\Database\MigrationServiceProvider as BaseMigrationServiceProvider;

/**
 * Class MigrationServiceProvider.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Database\Migration
 */
class MigrationServiceProvider extends BaseMigrationServiceProvider
{
    /**
     * Register the migration repository service.
     *
     * @return void
     */
    protected function registerRepository()
    {
        $this->app->singleton(
            'migration.repository',
            function ($app) {

                $table = $app['config']['database.migrations'];

                return new MigrationRepository($app['db'], $table);
            }
        );
    }

    /**
     * Register the migrator service.
     *
     * @return void
     */
    protected function registerMigrator()
    {
        // The migrator is responsible for actually running and rollback the migration
        // files in the application. We'll pass in our database connection resolver
        // so the migrator can resolve any of these connections when it needs to.
        $this->app->singleton(
            'migrator',
            function ($app) {

                $repository = $app['migration.repository'];

                return new Migrator($repository, $app['db'], $app['files']);
            }
        );
    }

    /**
     * Register the "make" migration command.
     *
     * @return void
     */
    protected function registerMakeCommand()
    {
        $this->registerCreator();

        $this->app->singleton(
            'command.migrate.make',
            function ($app) {

                // Once we have the migration creator registered, we will create the command
                // and inject the creator. The creator is responsible for the actual file
                // creation of the migrations, and may be extended by these developers.
                $creator  = $app['migration.creator'];
                $composer = $app['composer'];

                return new MigrateMakeCommand($creator, $composer);
            }
        );
    }

    /**
     * Register the "migrate" migration command.
     *
     * @return void
     */
    protected function registerMigrateCommand()
    {
        $this->app->singleton(
            'command.migrate',
            function ($app) {
                return new MigrateCommand($app['migrator']);
            }
        );
    }

    /**
     * Register the "reset" migration command.
     *
     * @return void
     */
    protected function registerResetCommand()
    {
        $this->app->singleton(
            'command.migrate.reset',
            function ($app) {
                return new ResetCommand($app['migrator']);
            }
        );
    }

    /**
     * Register the "refresh" migration command.
     *
     * @return void
     */
    protected function registerRefreshCommand()
    {
        $this->app->singleton(
            'command.migrate.refresh',
            function () {
                return new RefreshCommand;
            }
        );
    }

    /**
     * Register the migration creator.
     *
     * @return void
     */
    protected function registerCreator()
    {
        $this->app->singleton(
            'migration.creator',
            function ($app) {
                return new MigrationCreator($app['files']);
            }
        );
    }
}

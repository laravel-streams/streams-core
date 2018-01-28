<?php namespace Anomaly\Streams\Platform\Artisan;

use Anomaly\Streams\Platform\Database\Migration\Console\MigrateCommand;
use Anomaly\Streams\Platform\Database\Migration\Console\MigrateMakeCommand;
use Anomaly\Streams\Platform\Database\Migration\Console\RefreshCommand;
use Anomaly\Streams\Platform\Database\Migration\Console\ResetCommand;
use Anomaly\Streams\Platform\Database\Migration\Console\RollbackCommand;
use Anomaly\Streams\Platform\Database\Seeder\Console\SeedCommand;
use Anomaly\Streams\Platform\View\Twig\Console\TwigClear;

/**
 * Class StreamsConsoleProvider
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ArtisanServiceProvider extends \Illuminate\Foundation\Providers\ArtisanServiceProvider
{

    /**
     * The commands to register.
     *
     * @var array
     */
    protected $streamsCommands = [

        // Asset Commands
        'Anomaly\Streams\Platform\Asset\Console\Clear',

        // Installer Commands
        'Anomaly\Streams\Platform\Installer\Console\Install',

        // Twig Commands
        'Anomaly\Streams\Platform\View\Twig\Console\TwigClear',
        'Anomaly\Streams\Platform\View\Twig\Console\TwigClean', // @deprecated in 1.3 remove in 1.4 - use twig:clear

        // Streams Commands
        'Anomaly\Streams\Platform\Stream\Console\Make',
        'Anomaly\Streams\Platform\Stream\Console\Index',
        'Anomaly\Streams\Platform\Stream\Console\Compile',
        'Anomaly\Streams\Platform\Stream\Console\Refresh',
        'Anomaly\Streams\Platform\Stream\Console\Cleanup',
        'Anomaly\Streams\Platform\Stream\Console\Destroy',

        // Addon Commands
        'Anomaly\Streams\Platform\Addon\Console\MakeAddon',
        'Anomaly\Streams\Platform\Addon\Console\AddonInstall',
        'Anomaly\Streams\Platform\Addon\Console\AddonUninstall',
        'Anomaly\Streams\Platform\Addon\Console\AddonReinstall',
        'Anomaly\Streams\Platform\Addon\Console\AddonPublish',
        'Anomaly\Streams\Platform\Addon\Module\Console\Install',
        'Anomaly\Streams\Platform\Addon\Module\Console\Uninstall',
        'Anomaly\Streams\Platform\Addon\Module\Console\Reinstall',
        'Anomaly\Streams\Platform\Addon\Extension\Console\Install',
        'Anomaly\Streams\Platform\Addon\Extension\Console\Uninstall',
        'Anomaly\Streams\Platform\Addon\Extension\Console\Reinstall',

        // Application Commands
        'Anomaly\Streams\Platform\Application\Console\EnvSet',
        'Anomaly\Streams\Platform\Application\Console\AppPublish',
        'Anomaly\Streams\Platform\Application\Console\StreamsPublish',
    ];

    /**
     * Register the given commands.
     *
     * @param  array $commands
     * @return void
     */
    protected function registerCommands(array $commands)
    {
        parent::registerCommands($commands);

        $this->commands(
            array_unique(
                array_merge(
                    $this->streamsCommands,
                    config('streams.commands', [])
                )
            )
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerSeedCommand()
    {
        $this->app->singleton(
            'command.seed',
            function ($app) {
                return new SeedCommand($app['db']);
            }
        );
    }

    /**
     * Register the command.
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
     * Register the command.
     *
     * @return void
     */
    protected function registerMigrateMakeCommand()
    {
        $this->app->singleton(
            'command.migrate.make',
            function ($app) {
                // Once we have the migration creator registered, we will create the command
                // and inject the creator. The creator is responsible for the actual file
                // creation of the migrations, and may be extended by these developers.
                $creator = $app['migration.creator'];

                $composer = $app['composer'];

                return new MigrateMakeCommand($creator, $composer);
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerMigrateRefreshCommand()
    {
        $this->app->singleton(
            'command.migrate.refresh',
            function () {
                return new RefreshCommand();
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerMigrateResetCommand()
    {
        $this->app->singleton(
            'command.migrate.reset',
            function ($app) {
                return new ResetCommand($app['migrator']);
            }
        );
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerMigrateRollbackCommand()
    {
        $this->app->singleton(
            'command.migrate.rollback',
            function ($app) {
                return new RollbackCommand($app['migrator']);
            }
        );
    }
}

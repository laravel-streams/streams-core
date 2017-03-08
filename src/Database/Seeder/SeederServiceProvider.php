<?php namespace Anomaly\Streams\Platform\Database\Seeder;

use Anomaly\Streams\Platform\Database\Seeder\Console\SeederMakeCommand;
use Anomaly\Streams\Platform\Database\Seeder\Console\SeedCommand;
use Illuminate\Database\SeedServiceProvider;

/**
 * Class SeederServiceProvider
 *
 */
class SeederServiceProvider extends SeedServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerSeedCommand();

        $this->app->singleton(
            'seeder',
            function () {
                return new Seeder();
            }
        );
        
        $this->registerMakeCommand();

        $this->commands([
            'command.seed',
            'command.seeder.make',
        ]);
    }

    /**
     * Register the seed console command.
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
     * Register the "make" seeder command.
     *
     * @return void
     */
    protected function registerMakeCommand()
    {
        $this->app->singleton(
            'command.seeder.make',
            function ($app) {
                return new SeederMakeCommand($app['files'], $app['composer']);
            }
        );
    }
}

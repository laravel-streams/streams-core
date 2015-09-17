<?php

namespace Anomaly\Streams\Platform\Database\Seeder;

use Anomaly\Streams\Platform\Database\Seeder\Console\SeedCommand;
use Illuminate\Database\SeedServiceProvider;

/**
 * Class SeederServiceProvider.
 *
 * @package Anomaly\Streams\Platform\Database\Seeder
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

        $this->commands('command.seed');
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
}

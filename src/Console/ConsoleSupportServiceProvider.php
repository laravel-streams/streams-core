<?php namespace Anomaly\Streams\Platform\Console;


use Illuminate\Foundation\Providers\ConsoleSupportServiceProvider as BaseConsoleSupportServiceProvider;

class ConsoleSupportServiceProvider extends BaseConsoleSupportServiceProvider
{

    /**
     * The provider class names.
     *
     * @var array
     */
    protected $providers = [
        'Illuminate\Auth\GeneratorServiceProvider',
        'Illuminate\Console\ScheduleServiceProvider',
        'Anomaly\Streams\Platform\Database\Migration\MigrationServiceProvider',
        'Anomaly\Streams\Platform\Database\Seeder\SeederServiceProvider',
        'Illuminate\Foundation\Providers\ComposerServiceProvider',
        'Illuminate\Queue\ConsoleServiceProvider',
        'Illuminate\Routing\GeneratorServiceProvider',
        'Illuminate\Session\CommandsServiceProvider',
    ];

}
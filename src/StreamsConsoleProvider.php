<?php namespace Anomaly\Streams\Platform;

use Illuminate\Foundation\Providers\ConsoleSupportServiceProvider;

/**
 * Class StreamsConsoleProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform
 */
class StreamsConsoleProvider extends ConsoleSupportServiceProvider
{

    /**
     * The provider class names.
     *
     * @var array
     */
    protected $providers = [
        'Illuminate\Auth\GeneratorServiceProvider',
        'Illuminate\Console\ScheduleServiceProvider',
        'Anomaly\Streams\Platform\Database\DatabaseServiceProvider',
        'Illuminate\Foundation\Providers\ComposerServiceProvider',
        'Illuminate\Queue\ConsoleServiceProvider',
        'Illuminate\Routing\GeneratorServiceProvider',
        'Illuminate\Session\CommandsServiceProvider',
    ];

}

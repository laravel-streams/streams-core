<?php namespace Anomaly\Streams\Platform\Console;

use Illuminate\Foundation\Providers\ConsoleSupportServiceProvider as BaseConsoleSupportServiceProvider;

/**
 * Class ConsoleSupportServiceProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Console
 */
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
        'Anomaly\Streams\Platform\Database\DatabaseServiceProvider',
        'Illuminate\Foundation\Providers\ComposerServiceProvider',
        'Illuminate\Queue\ConsoleServiceProvider',
        'Illuminate\Routing\GeneratorServiceProvider',
        'Illuminate\Session\CommandsServiceProvider',
    ];

}

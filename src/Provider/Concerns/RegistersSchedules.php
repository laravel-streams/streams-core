<?php

namespace Anomaly\Streams\Platform\Provider\Concerns;

use Illuminate\Console\Scheduling\Schedule;

/**
 * Trait RegistersSchedules
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
trait RegistersSchedules
{

    /**
     * The scheduled commands.
     *
     * @var array
     */
    public $schedules = [];

    /**
     * Register the scheduled commands.
     */
    protected function registerSchedules()
    {
        if (!$this->schedules) {
            return;
        }

        $schedule = app(Schedule::class);

        foreach ($this->schedules as $frequency => $commands) {

            foreach (array_filter($commands) as $command => $options) {

                /**
                 * If the option is a string
                 * then treat it as the command.
                 */
                if (is_string($options)) {
                    $command = $options;
                    $options = [];
                }

                /**
                 * If the frequency is a CRON
                 * expression then use that.
                 */
                if (str_is('* * * *', $frequency)) {
                    $command = $schedule
                        ->command($command)
                        ->cron($frequency);
                }

                /**
                 * If the frequency is not a CRON
                 * expression then it's a method.
                 */
                if (!str_is('* * * *', $frequency)) {

                    // Unpack {method}:{arg1},{arg2},...
                    $parts = explode(':', $frequency);

                    // First part is the method.
                    $method = camel_case(array_shift($parts));

                    // The rest are arguments.
                    $arguments = explode(',', array_shift($parts));

                    // Use the method to create the command.
                    $command = call_user_func_array([
                        $schedule->command($command), $method
                    ], $arguments);
                }

                /**
                 * Loop over any options and chain them
                 * onto the command we just built.
                 * 
                 * Option keys are snake-cased to form
                 * the methods used to configure the command.
                 */
                foreach ($options as $option => $arguments) {

                    /**
                     * If the arguments are a string
                     * then treat them like the method
                     * and just run it with no arguments.
                     */
                    if (is_string($arguments)) {
                        $option    = $arguments;
                        $arguments = [];
                    }

                    $command = call_user_func_array([
                        $command, camel_case($option)
                    ], (array) $arguments);
                }
            }
        }
    }
}

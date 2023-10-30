<?php namespace Anomaly\Streams\Platform\Console;

/**
 * Class Kernel
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Kernel extends \Illuminate\Foundation\Console\Kernel
{
    /**
     * Include base commands.
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}

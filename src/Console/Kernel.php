<?php namespace Anomaly\Streams\Platform\Console;

use Illuminate\Contracts\Events\Dispatcher;

/**
 * Class Kernel
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\Streams\Platform\Console
 */
class Kernel extends \App\Console\Kernel
{

    /**
     * Get the Artisan application instance.
     *
     * @return \Illuminate\Console\Application
     */
    protected function getArtisan()
    {
        if (is_null($this->artisan)) {
            return $this->artisan = (new Application($this->app, $this->events, $this->app->version()))
                ->resolveCommands($this->commands);
        }

        return $this->artisan;
    }
}

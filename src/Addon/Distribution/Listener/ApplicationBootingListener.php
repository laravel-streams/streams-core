<?php namespace Anomaly\Streams\Platform\Addon\Distribution\Listener;

use Anomaly\Streams\Platform\Addon\Theme\Command\DetectActiveThemeCommand;
use Illuminate\Foundation\Bus\DispatchesCommands;

/**
 * Class ApplicationBootingListener
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Distribution\Listener
 */
class ApplicationBootingListener
{

    use DispatchesCommands;

    /**
     * When the application is booting detect the active
     * distribution and setup our environment with it.
     */
    public function handle()
    {
        $this->dispatch(new DetectActiveThemeCommand());
    }
}

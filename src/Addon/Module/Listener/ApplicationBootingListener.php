<?php namespace Anomaly\Streams\Platform\Addon\Module\Listener;

use Anomaly\Streams\Platform\Addon\Module\Command\DetectActiveModuleCommand;
use Illuminate\Foundation\Bus\DispatchesCommands;

/**
 * Class ApplicationBootingListener
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Module\Listener
 */
class ApplicationBootingListener
{

    use DispatchesCommands;

    /**
     * When the application is booting detect the
     * default module and setup our environment with it.
     */
    public function handle()
    {
        $this->dispatch(new DetectActiveModuleCommand());
    }
}

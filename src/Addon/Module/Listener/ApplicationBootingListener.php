<?php namespace Anomaly\Streams\Platform\Addon\Module\Listener;

use Laracasts\Commander\CommanderTrait;

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

    use CommanderTrait;

    /**
     * When the application is booting detect the
     * default module and setup our environment with it.
     */
    public function handle()
    {
        $this->execute('\Anomaly\Streams\Platform\Addon\Module\Command\DetectActiveModuleCommand');
    }
}

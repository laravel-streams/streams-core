<?php namespace Anomaly\Streams\Platform\Addon\Distribution\Listener;

use Laracasts\Commander\CommanderTrait;

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

    use CommanderTrait;

    /**
     * When the application is booting detect the active
     * distribution and setup our environment with it.
     */
    public function handle()
    {
        $this->execute('\Anomaly\Streams\Platform\Addon\Distribution\Command\DetectActiveDistributionCommand');
    }
}

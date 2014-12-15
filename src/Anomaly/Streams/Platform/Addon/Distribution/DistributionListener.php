<?php namespace Anomaly\Streams\Platform\Addon\Distribution;

use Laracasts\Commander\CommanderTrait;
use Laracasts\Commander\Events\EventListener;

/**
 * Class DistributionListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Distribution
 */
class DistributionListener extends EventListener
{

    use CommanderTrait;

    /**
     * Fired when the ApplicationServiceProvider starts booting.
     */
    public function whenApplicationIsBooting()
    {
        $this->execute('\Anomaly\Streams\Platform\Addon\Distribution\Command\DetectActiveDistributionCommand');
    }
}

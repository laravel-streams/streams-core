<?php namespace Anomaly\Streams\Platform\Addon\Distribution;

use Anomaly\Streams\Platform\Addon\AddonListener;
use Laracasts\Commander\Events\DispatchableTrait;

/**
 * Class DistributionListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Distribution
 */
class DistributionListener extends AddonListener
{
    use DispatchableTrait;

    public function whenStreamsIsBooting()
    {
        $this->execute('\Anomaly\Streams\Platform\Addon\Distribution\Command\DetectActiveDistributionCommand');
    }
}

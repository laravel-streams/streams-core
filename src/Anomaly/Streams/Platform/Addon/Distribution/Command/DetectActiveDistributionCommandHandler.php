<?php namespace Anomaly\Streams\Platform\Addon\Distribution\Command;

use Anomaly\Streams\Platform\Addon\Distribution\Distribution;

/**
 * Class DetectActiveDistributionCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Distribution\Command
 */
class DetectActiveDistributionCommandHandler
{

    /**
     * Handle the command.
     */
    public function handle()
    {
        /**
         * If we have an active distribution then add
         * all it's namespaces to all our utilities.
         */
        if ($distribution = app('streams.distributions')->active()) {
            $this->setDistributionNamespaces($distribution);
        }
    }

    /**
     * Set the "distribution" namespace.
     *
     * @param Distribution $distribution
     */
    protected function setDistributionNamespaces(Distribution $distribution)
    {
        app('view')->addNamespace('distribution', $distribution->getPath('resources/views'));
        app('translator')->addNamespace('distribution', $distribution->getPath('resources/lang'));

        app('streams.asset')->addNamespace('distribution', $distribution->getPath('resources'));
        app('streams.image')->addNamespace('distribution', $distribution->getPath('resources'));
    }
}

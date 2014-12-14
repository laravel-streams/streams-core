<?php namespace Anomaly\Streams\Platform\Addon\Distribution\Command;

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
            app('view')->addNamespace('distribution', $distribution->getPath('resources/views'));
            app('streams.asset')->addNamespace('distribution', $distribution->getPath('resources'));
            app('streams.image')->addNamespace('distribution', $distribution->getPath('resources'));
            app('translator')->addNamespace('distribution', $distribution->getPath('resources/lang'));
        }
    }
}

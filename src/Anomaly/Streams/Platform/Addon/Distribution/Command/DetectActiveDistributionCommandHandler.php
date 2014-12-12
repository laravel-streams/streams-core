<?php namespace Anomaly\Streams\Platform\Addon\Distribution\Command;

class DetectActiveDistributionCommandHandler
{
    public function handle()
    {
        if ($distribution = app('streams.distributions')->active()) {
            // Setup namespace hints for a short namespace.
            app('view')->addNamespace('distribution', $distribution->getPath('resources/views'));
            app('streams.asset')->addNamespace('distribution', $distribution->getPath('resources'));
            app('streams.image')->addNamespace('distribution', $distribution->getPath('resources'));
            app('translator')->addNamespace('distribution', $distribution->getPath('resources/lang'));
        }
    }
}

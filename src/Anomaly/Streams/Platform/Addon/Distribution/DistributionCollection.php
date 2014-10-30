<?php namespace Anomaly\Streams\Platform\Addon\Distribution;

use Anomaly\Streams\Platform\Addon\AddonCollection;

class DistributionCollection extends AddonCollection
{

    public function active()
    {
        return $this->first();
    }
}
 
<?php namespace Streams\Platform\Addon\Distribution;

use Streams\Platform\Addon\AddonCollection;

class DistributionCollection extends AddonCollection
{
    public function active()
    {
        return $this->first();
    }
}
 
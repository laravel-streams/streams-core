<?php namespace Anomaly\Streams\Platform\Addon\Event;

use Anomaly\Streams\Platform\Addon\Addon;

class AddonHasRegistered
{
    protected $addon;

    function __construct(Addon $addon)
    {
        $this->addon = $addon;
    }

    public function getAddon()
    {
        return $this->addon;
    }
}

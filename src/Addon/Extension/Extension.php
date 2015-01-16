<?php namespace Anomaly\Streams\Platform\Addon\Extension;

use Anomaly\Streams\Platform\Addon\Addon;

/**
 * Class Extension
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Extension
 */
class Extension extends Addon
{

    /**
     * The extension identifier.
     *
     * @var null|string
     */
    protected $identifier = null;

    /**
     * Get the identifier.
     *
     * @return null|string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }
}

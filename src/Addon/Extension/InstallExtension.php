<?php namespace Anomaly\Streams\Platform\Addon\Extension\Command;

use Anomaly\Streams\Platform\Addon\Extension\Extension;

/**
 * Class InstallExtension
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Extension\Command
 */
class InstallExtension
{

    /**
     * The seed flag.
     *
     * @var bool
     */
    protected $seed;

    /**
     * The extension to install.
     *
     * @var Extension
     */
    protected $extension;

    /**
     * Create a new InstallExtension instance.
     *
     * @param Extension $extension
     * @param bool   $seed
     */
    function __construct(Extension $extension, $seed = false)
    {
        $this->seed   = $seed;
        $this->extension = $extension;
    }

    /**
     * Get the seed flag.
     *
     * @return bool
     */
    public function getSeed()
    {
        return $this->seed;
    }

    /**
     * Get the extension.
     *
     * @return Extension
     */
    public function getExtension()
    {
        return $this->extension;
    }
}

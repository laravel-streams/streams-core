<?php namespace Anomaly\Streams\Platform\Addon\Extension\Command;

use Anomaly\Streams\Platform\Addon\Extension\Extension;

/**
 * Class UninstallExtension
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Extension\Command
 */
class UninstallExtension
{

    /**
     * The extension to uninstall.
     *
     * @var Extension
     */
    protected $extension;

    /**
     * Create a new UninstallExtension instance.
     *
     * @param Extension $extension
     */
    public function __construct(Extension $extension)
    {
        $this->extension = $extension;
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

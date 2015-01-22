<?php namespace Anomaly\Streams\Platform\Addon\Extension\Command;

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
     * The extension object.
     *
     * @var
     */
    protected $extension;

    /**
     * Create a new UninstallExtension command.
     *
     * @param $extension
     */
    public function __construct($extension)
    {
        $this->extension = $extension;
    }

    /**
     * Get the extension object.
     *
     * @return mixed
     */
    public function getExtension()
    {
        return $this->extension;
    }
}

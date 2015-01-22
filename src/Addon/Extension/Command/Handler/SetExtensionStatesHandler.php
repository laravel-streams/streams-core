<?php namespace Anomaly\Streams\Platform\Addon\Extension\Command\Handler;

use Anomaly\Streams\Platform\Addon\Extension\ExtensionCollection;

/**
 * Class SetExtensionStatesHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Extension\Command
 */
class SetExtensionStatesHandler
{

    /**
     * The loaded extensions.
     *
     * @var \Anomaly\Streams\Platform\Addon\Extension\ExtensionCollection
     */
    protected $extensions;

    /**
     * Create a new SetExtensionStatesHandler instance.
     *
     * @param ExtensionCollection $extensions
     */
    public function __construct(ExtensionCollection $extensions)
    {
        $this->extensions = $extensions;
    }

    /**
     * Set the installed / enabled status of
     * all of the registered extensions.
     */
    public function handle()
    {
        $states = app('db')
            ->table('addons_extensions')
            ->where('installed', true)
            ->get();

        $this->extensions->setStates($states);
    }
}

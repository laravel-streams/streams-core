<?php namespace Anomaly\Streams\Platform\Addon\Extension\Command\Handler;

use Anomaly\Streams\Platform\Addon\Extension\Extension;
use Anomaly\Streams\Platform\Addon\Extension\ExtensionCollection;
use Anomaly\Streams\Platform\Addon\Extension\ExtensionManager;

/**
 * Class InstallAllExtensionsHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Extension\Command
 */
class InstallAllExtensionsHandler
{

    /**
     * The extension manager.
     *
     * @var ExtensionManager
     */
    protected $manager;

    /**
     * The loaded extensions.
     *
     * @var ExtensionCollection
     */
    protected $extensions;

    /**
     * Create a new InstallAllExtensionsHandler instance.
     *
     * @param ExtensionManager $service
     */
    public function __construct(ExtensionCollection $extensions, ExtensionManager $service)
    {
        $this->manager    = $service;
        $this->extensions = $extensions;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        foreach ($this->extensions->all() as $extension) {
            $this->installExtension($extension);
        }
    }

    /**
     * Install a extension.
     *
     * @param Extension $extension
     */
    protected function installExtension(Extension $extension)
    {
        $this->manager->install($extension->getSlug());
    }
}

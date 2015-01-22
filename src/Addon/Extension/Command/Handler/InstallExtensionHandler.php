<?php namespace Anomaly\Streams\Platform\Addon\Extension\Command\Handler;

use Anomaly\Streams\Platform\Addon\Extension\Command\InstallExtension;
use Anomaly\Streams\Platform\Addon\Extension\Event\ExtensionWasInstalled;
use Anomaly\Streams\Platform\Addon\Extension\Extension;
use Anomaly\Streams\Platform\Addon\Extension\ExtensionCollection;
use Anomaly\Streams\Platform\Addon\Extension\ExtensionInstaller;
use Anomaly\Streams\Platform\Contract\Installable;
use Illuminate\Events\Dispatcher;

/**
 * Class InstallExtensionHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Extension\Command
 */
class InstallExtensionHandler
{

    /**
     * The loaded extensions.
     *
     * @var \Anomaly\Streams\Platform\Addon\Extension\ExtensionCollection
     */
    protected $extensions;

    /**
     * The event dispatcher.
     *
     * @var \Illuminate\Events\Dispatcher
     */
    protected $dispatcher;

    /**
     * Create a new InstallExtensionHandler instance.
     *
     * @param ExtensionCollection $extensions
     * @param Dispatcher       $dispatcher
     */
    public function __construct(ExtensionCollection $extensions, Dispatcher $dispatcher)
    {
        $this->extensions    = $extensions;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Install a extension.
     *
     * @param  InstallExtension $command
     * @return bool
     */
    public function handle(InstallExtension $command)
    {
        $extension = $this->extensions->findBySlug($command->getExtension());

        if (!$extension) {
            throw new \Exception("Extension [$command->getExtension()] not be found.");
        }

        if ($installer = $extension->newInstaller()) {
            $this->runInstallers($extension, $installer);
        }

        $this->dispatcher->fire(new ExtensionWasInstalled($extension));

        return true;
    }

    /**
     * Run the extension's installers.
     *
     * @param Extension          $extension
     * @param ExtensionInstaller $installer
     */
    protected function runInstallers(Extension $extension, ExtensionInstaller $installer)
    {
        foreach ($installer->getInstallers() as $installer) {
            $installer = $this->resolveInstaller($extension, $installer);

            $this->runInstaller($installer);
        }
    }

    /**
     * Run an installer.
     *
     * @param Installable $installer
     */
    protected function runInstaller(Installable $installer)
    {
        $installer->install();
    }

    /**
     * Resolve the installer.
     *
     * @param  Extension $extension
     * @param         $installer
     * @return mixed
     */
    protected function resolveInstaller(Extension $extension, $installer)
    {
        return app()->make($installer, ['addon' => $extension]);
    }
}

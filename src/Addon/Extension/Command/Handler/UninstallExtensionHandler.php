<?php namespace Anomaly\Streams\Platform\Addon\Extension\Command\Handler;

use Anomaly\Streams\Platform\Addon\Extension\Command\UninstallExtension;
use Anomaly\Streams\Platform\Addon\Extension\Event\ExtensionWasUninstalled;
use Anomaly\Streams\Platform\Addon\Extension\Extension;
use Anomaly\Streams\Platform\Addon\Extension\ExtensionCollection;
use Anomaly\Streams\Platform\Addon\Extension\ExtensionInstaller;
use Anomaly\Streams\Platform\Contract\Installable;
use Illuminate\Events\Dispatcher;

/**
 * Class UninstallExtensionHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Extension\Command
 */
class UninstallExtensionHandler
{

    /**
     * The loaded extension.
     *
     * @var ExtensionCollection
     */
    protected $extensions;

    /**
     * The event dispatcher.
     *
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * Create a new UninstallExtensionHandler instance.
     *
     * @param ExtensionCollection $extensions
     * @param Dispatcher          $dispatcher
     */
    function __construct(ExtensionCollection $extensions, Dispatcher $dispatcher)
    {
        $this->extensions = $extensions;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Handle the command.
     *
     * @param  UninstallExtension $command
     * @return bool
     */
    public function handle(UninstallExtension $command)
    {
        $extension = $this->extensions->findBySlug($command->getExtension());

        if (!$extension instanceof Extension) {
            throw new \Exception("Extension [$command->getExtension()] not be found.");
        }

        if ($installer = $extension->newInstaller()) {
            $this->runInstallers($extension, $installer);
        }

        $this->dispatcher->fire(new ExtensionWasUninstalled($extension));

        return true;
    }

    /**
     * Run the installers.
     *
     * @param Extension          $extension
     * @param ExtensionInstaller $installer
     */
    protected function runInstallers(Extension $extension, ExtensionInstaller $installer)
    {
        foreach ($installer->getInstallers() as $installer) {
            $installer = $this->resolveInstaller($extension, $installer);

            $this->runUninstall($installer);
        }
    }

    /**
     * Run the installer's uninstall method.
     *
     * @param Installable $installer
     */
    protected function runUninstall(Installable $installer)
    {
        $installer->uninstall();
    }

    /**
     * Resolve the installer.
     *
     * @param  Extension $extension
     * @param            $installer
     * @return mixed
     */
    protected function resolveInstaller(Extension $extension, $installer)
    {
        return app()->make($installer, ['addon' => $extension]);
    }
}

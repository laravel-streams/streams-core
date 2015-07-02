<?php namespace Anomaly\Streams\Platform\Addon\Extension\Command\Handler;

use Anomaly\Streams\Platform\Addon\Extension\Command\UninstallExtension;
use Anomaly\Streams\Platform\Addon\Extension\Event\ExtensionWasUninstalled;
use Anomaly\Streams\Platform\Addon\Extension\ExtensionCollection;
use App\Console\Kernel;
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
     * The service container.
     *
     * @var Kernel
     */
    protected $command;

    /**
     * The loaded extensions.
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
     * @param Kernel              $kernel
     * @param Dispatcher          $dispatcher
     */
    public function __construct(ExtensionCollection $extensions, Kernel $kernel, Dispatcher $dispatcher)
    {
        $this->command    = $kernel;
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
        $extension = $command->getExtension();

        $options = [
            '--addon' => $extension->getNamespace()
        ];

        $this->command->call('migrate:reset', $options);
        $this->dispatcher->fire(new ExtensionWasUninstalled($extension));

        return true;
    }
}

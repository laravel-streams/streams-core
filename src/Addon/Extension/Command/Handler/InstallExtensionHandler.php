<?php namespace Anomaly\Streams\Platform\Addon\Extension\Command\Handler;

use Anomaly\Streams\Platform\Addon\Extension\Command\InstallExtension;
use Anomaly\Streams\Platform\Addon\Extension\Event\ExtensionWasInstalled;
use Anomaly\Streams\Platform\Addon\Extension\ExtensionCollection;
use App\Console\Kernel;
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
     * Create a new InstallExtensionHandler instance.
     *
     * @param ExtensionCollection $extensions
     * @param Kernel           $kernel
     * @param Dispatcher       $dispatcher
     */
    public function __construct(ExtensionCollection $extensions, Kernel $kernel, Dispatcher $dispatcher)
    {
        $this->command    = $kernel;
        $this->extensions    = $extensions;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Handle the command.
     *
     * @param  InstallExtension $kernel
     * @return bool
     */
    public function handle(InstallExtension $kernel)
    {
        $extension = $kernel->getExtension();

        $options = [
            '--addon' => $extension->getNamespace(),
            '--force' => true
        ];

        if ($kernel->getSeed()) {
            $options['--seed'] = true;
        }

        $this->command->call('migrate', $options);
        $this->dispatcher->fire(new ExtensionWasInstalled($extension));

        return true;
    }
}

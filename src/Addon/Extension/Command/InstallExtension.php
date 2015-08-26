<?php namespace Anomaly\Streams\Platform\Addon\Extension\Command;

use Anomaly\Streams\Platform\Addon\Extension\Contract\ExtensionRepositoryInterface;
use Anomaly\Streams\Platform\Addon\Extension\Event\ExtensionWasInstalled;
use Anomaly\Streams\Platform\Addon\Extension\Extension;
use App\Console\Kernel;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Events\Dispatcher;

/**
 * Class InstallExtension
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Extension\Command
 */
class InstallExtension implements SelfHandling
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
     * @param bool      $seed
     */
    function __construct(Extension $extension, $seed = false)
    {
        $this->seed      = $seed;
        $this->extension = $extension;
    }

    /**
     * Handle the command.
     *
     * @param  InstallExtension $kernel
     * @return bool
     */
    public function handle(Kernel $kernel, Dispatcher $dispatcher, ExtensionRepositoryInterface $extensions)
    {
        $options = [
            '--addon' => $this->extension->getNamespace(),
            '--force' => true
        ];

        $kernel->call('migrate:refresh', $options);

        $extensions->install($this->extension);

        $dispatcher->fire(new ExtensionWasInstalled($this->extension));

        return true;
    }
}

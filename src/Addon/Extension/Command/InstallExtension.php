<?php namespace Anomaly\Streams\Platform\Addon\Extension\Command;

use Anomaly\Streams\Platform\Addon\AddonManager;
use Anomaly\Streams\Platform\Addon\Extension\Contract\ExtensionRepositoryInterface;
use Anomaly\Streams\Platform\Addon\Extension\Event\ExtensionWasInstalled;
use Anomaly\Streams\Platform\Addon\Extension\Extension;
use App\Console\Kernel;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Events\Dispatcher;

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
     * @param InstallExtension|Kernel      $console
     * @param AddonManager                 $manager
     * @param Dispatcher                   $dispatcher
     * @param ExtensionRepositoryInterface $extensions
     * @return bool
     */
    public function handle(
        Kernel $console,
        AddonManager $manager,
        Dispatcher $dispatcher,
        ExtensionRepositoryInterface $extensions
    ) {
        $this->extension->fire('installing');

        $options = [
            '--addon' => $this->extension->getNamespace(),
            '--force' => true
        ];

        $console->call('migrate:refresh', $options);

        $extensions->install($this->extension);

        $manager->register();

        if ($this->seed) {
            $console->call('db:seed', $options);
        }

        $this->extension->fire('installed');

        $dispatcher->fire(new ExtensionWasInstalled($this->extension));

        return true;
    }
}

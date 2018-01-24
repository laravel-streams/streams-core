<?php namespace Anomaly\Streams\Platform\Addon\Extension\Command;

use Anomaly\Streams\Platform\Addon\AddonManager;
use Anomaly\Streams\Platform\Addon\Extension\Contract\ExtensionRepositoryInterface;
use Anomaly\Streams\Platform\Addon\Extension\Event\ExtensionWasInstalled;
use Anomaly\Streams\Platform\Addon\Extension\Extension;
use Anomaly\Streams\Platform\Console\Kernel;
use Illuminate\Contracts\Events\Dispatcher;

/**
 * Class InstallExtension
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class InstallExtension
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
    public function __construct(Extension $extension, $seed = false)
    {
        $this->seed      = $seed;
        $this->extension = $extension;
    }

    /**
     * Handle the command.
     *
     * @param  InstallExtension|Kernel      $console
     * @param  AddonManager                 $manager
     * @param  Dispatcher                   $dispatcher
     * @param  ExtensionRepositoryInterface $extensions
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
            '--force' => true,
        ];

        $console->call('migrate', $options);

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

<?php namespace Anomaly\Streams\Platform\Addon\Module\Command;

use Anomaly\Streams\Platform\Addon\AddonManager;
use Anomaly\Streams\Platform\Addon\Module\Contract\ModuleRepositoryInterface;
use Anomaly\Streams\Platform\Addon\Module\Event\ModuleWasInstalled;
use Anomaly\Streams\Platform\Addon\Module\Module;
use App\Console\Kernel;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Events\Dispatcher;

/**
 * Class InstallModule
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Module\Command
 */
class InstallModule implements SelfHandling
{

    /**
     * The seed flag.
     *
     * @var bool
     */
    protected $seed;

    /**
     * The module to install.
     *
     * @var Module
     */
    protected $module;

    /**
     * Create a new InstallModule instance.
     *
     * @param Module $module
     * @param bool   $seed
     */
    function __construct(Module $module, $seed = false)
    {
        $this->seed   = $seed;
        $this->module = $module;
    }

    /**
     * Handle the command.
     *
     * @param Kernel                    $console
     * @param AddonManager              $manager
     * @param Dispatcher                $dispatcher
     * @param ModuleRepositoryInterface $modules
     * @return bool
     */
    public function handle(
        Kernel $console,
        AddonManager $manager,
        Dispatcher $dispatcher,
        ModuleRepositoryInterface $modules
    ) {
        $this->module->fire('installing');

        $options = [
            '--addon' => $this->module->getNamespace(),
            '--force' => true
        ];

        $console->call('migrate:refresh', $options);

        $modules->install($this->module);

        $manager->register();

        if ($this->seed) {
            $console->call('db:seed', $options);
        }

        $this->module->fire('installed');

        $dispatcher->fire(new ModuleWasInstalled($this->module));

        return true;
    }
}

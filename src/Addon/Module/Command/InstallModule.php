<?php

namespace Anomaly\Streams\Platform\Addon\Module\Command;

use Anomaly\Streams\Platform\Addon\Module\Contract\ModuleRepositoryInterface;
use Anomaly\Streams\Platform\Addon\Module\Event\ModuleWasInstalled;
use Anomaly\Streams\Platform\Addon\Module\Module;
use \Illuminate\Contracts\Console\Kernel;

/**
 * Class InstallModule
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class InstallModule
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
     * @param bool $seed
     */
    public function __construct(Module $module, $seed = false)
    {
        $this->seed   = $seed;
        $this->module = $module;
    }

    /**
     * Handle the command.
     *
     * @param  Kernel $console
     * @param  ModuleRepositoryInterface $modules
     * @return bool
     */
    public function handle(
        Kernel $console,
        ModuleRepositoryInterface $modules
    ) {
        $this->module->fire('installing', ['module' => $this->module]);

        $options = [
            'addon' => $this->module->getNamespace(),
            //'--force' => true,
        ];

        $console->call('addon:migrate', $options);

        $modules->install($this->module);

        if ($this->seed) {
            $console->call('addon:seed', $options);
        }

        $this->module->fire('installed', ['module' => $this->module]);

        event(new ModuleWasInstalled($this->module));

        return true;
    }
}

<?php namespace Anomaly\Streams\Platform\Installer\Console\Command;

use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Installer\Installer;
use Anomaly\Streams\Platform\Installer\InstallerCollection;
use App\Console\Kernel;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class LoadModuleInstallers
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Installer\Console\Command
 */
class LoadModuleInstallers implements SelfHandling
{

    /**
     * The installer collection.
     *
     * @var InstallerCollection
     */
    protected $installers;

    /**
     * Create a new LoadModuleInstallers instance.
     *
     * @param InstallerCollection $installers
     */
    public function __construct(InstallerCollection $installers)
    {
        $this->installers = $installers;
    }

    /**
     * Handle the command.
     *
     * @param ModuleCollection $modules
     */
    public function handle(ModuleCollection $modules)
    {
        /* @var Module $module */
        foreach ($modules as $module) {

            if ($module->getNamespace() == 'anomaly.module.installer') {
                continue;
            }

            $this->installers->add(
                new Installer(
                    trans('streams::installer.installing', ['installing' => trans($module->getName())]),
                    function (Kernel $console) use ($module) {
                        $console->call('module:install', ['module' => $module->getNamespace()]);
                    }
                )
            );
        }
    }
}

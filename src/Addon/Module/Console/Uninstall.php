<?php namespace Anomaly\Streams\Platform\Addon\Module\Console;

use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Addon\Module\ModuleManager;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Exception;

/**
 * Class Uninstall
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Uninstall extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'module:uninstall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uninstall a module.';

    /**
     * Execute the console command.
     *
     * @param ModuleManager    $manager
     * @param ModuleCollection $modules
     */
    public function handle(ModuleManager $manager, ModuleCollection $modules)
    {
        /* @var Module $module */
        $module = $modules->get($this->argument('module'));

        if (!$module) {
            throw new Exception('Module ' . $this->argument('module') . ' does not exist or is not installed.');
        }

        $manager->uninstall($module);

        $this->info(trans($module->getName()) . ' uninstalled successfully!');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['module', InputArgument::REQUIRED, 'The module\'s dot namespace.'],
        ];
    }
}

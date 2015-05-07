<?php namespace Anomaly\Streams\Platform\Addon\Module\Console;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Addon\Module\ModuleManager;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class Uninstall
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Stream\Console
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
    public function fire(ModuleManager $manager, ModuleCollection $modules)
    {
        $manager->uninstall($module = $modules->get($this->argument('module')));

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

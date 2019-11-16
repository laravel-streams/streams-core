<?php

namespace Anomaly\Streams\Platform\Addon\Console;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Addon\Extension\Extension;
use Anomaly\Streams\Platform\Addon\Extension\ExtensionManager;
use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Addon\Module\ModuleManager;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class AddonInstall
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AddonInstall extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'addon:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install an addon.';

    /**
     * Execute the console command.
     *
     * @param ModuleManager    $modules
     * @param ExtensionManager $extensions
     */
    public function handle(ModuleManager $modules, ExtensionManager $extensions)
    {
        $addon = app($this->argument('addon'));

        if ($addon instanceof Module) {

            $modules->install($addon, $this->option('seed'));

            $this->info('The [' . $this->argument('addon') . '] module was installed.');
        }

        if ($addon instanceof Extension) {

            $extensions->install($addon, $this->option('seed'));

            $this->info('The [' . $this->argument('addon') . '] extension was installed.');
        }
    }

    /**
     * Get the command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['addon', InputArgument::REQUIRED, 'The addon to install.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['seed', null, InputOption::VALUE_NONE, 'Seed the addon after installing?'],
        ];
    }
}

<?php namespace Anomaly\Streams\Platform\Addon\Module\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class Reinstall
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Reinstall extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'module:reinstall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reinstall a module.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('module:uninstall', ['module' => $this->argument('module')]);
        $this->call('module:install', ['module' => $this->argument('module'), '--seed' => $this->option('seed')]);
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

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['seed', null, InputOption::VALUE_NONE, 'Seed the module after installing?'],
        ];
    }
}

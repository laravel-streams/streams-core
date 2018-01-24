<?php namespace Anomaly\Streams\Platform\Addon\Extension\Console;

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
    protected $name = 'extension:reinstall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reinstall a extension.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('extension:uninstall', ['extension' => $this->argument('extension')]);
        $this->call(
            'extension:install',
            ['extension' => $this->argument('extension'), '--seed' => $this->option('seed')]
        );
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['extension', InputArgument::REQUIRED, 'The extension\'s dot namespace.'],
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
            ['seed', null, InputOption::VALUE_NONE, 'Seed the extension after installing?'],
        ];
    }
}

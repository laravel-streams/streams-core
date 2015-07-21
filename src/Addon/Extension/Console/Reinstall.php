<?php namespace Anomaly\Streams\Platform\Addon\Extension\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class Reinstall
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Stream\Console
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
    public function fire()
    {
        $this->call('extension:uninstall', ['extension' => $this->argument('extension')]);
        $this->call('extension:install', ['extension' => $this->argument('extension')]);
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
}

<?php namespace Anomaly\Streams\Platform\Database\Migration\Console\Command;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Addon\Command\GetAddon;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Console\Command;

class MigrateStreams
{
    use DispatchesJobs;

    /**
     * Streams migration paths.
     *
     * @var array
     */
    protected $paths = [
        'vendor/anomaly/streams-platform/migrations/core',
        'vendor/anomaly/streams-platform/migrations/application',
    ];

    /**
     * The console command.
     *
     * @var Command
     */
    protected $command;

    /**
     * Create a new SetAddonPath instance.
     *
     * @param ResetCommand $command
     */
    public function __construct(Command $command)
    {
        $this->command = $command;
    }

    /**
     * Handle the command.
     *
     * @param AddonCollection $addons
     */
    public function handle(AddonCollection $addons)
    {
        foreach ($this->paths as $path) {
            $options = [
                '--path' => $path,
            ];

            if ($this->command->option('force')) {
                $options['--force'] = true;
            }

            if ($this->command->option('pretend')) {
                $options['--pretend'] = true;
            }

            if ($this->command->option('seed')) {
                $options['--seed'] = true;
            }

            if ($database = $this->command->option('database')) {
                $options['--database'] = $database;
            }

            $this->command->call('migrate', $options);
        }

        return;
    }
}

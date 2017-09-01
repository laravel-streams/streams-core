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
     */
    public function handle()
    {
        foreach ($this->paths as $path) {
            $options = [
                '--path' => $path,
            ];

            foreach (['force', 'pretend', 'seed', 'database'] as $key) {
                if ($value = $this->command->option('force')) {
                    array_set($options, '--' . $key, $value);
                }
            }

            $this->command->call('migrate', $options);
        }

        return;
    }
}

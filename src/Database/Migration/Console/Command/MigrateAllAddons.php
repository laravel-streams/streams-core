<?php namespace Anomaly\Streams\Platform\Database\Migration\Console\Command;

use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Addon\Command\GetAddon;
use Anomaly\Streams\Platform\Http\Kernel;

class MigrateAllAddons
{
    use DispatchesJobs;

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
    public function handle(AddonCollection $addons, Kernel $artisan)
    {
        foreach ($addons->installable() as $addon) {
            $options = [
                '--addon' => $addon->getNamespace(),
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

            $artisan->call('migrate', $options);

            $this->command->info('Migrated ' . $addon->getNamespace());
        }

        return;
    }
}

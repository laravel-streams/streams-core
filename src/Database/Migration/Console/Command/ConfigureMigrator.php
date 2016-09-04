<?php namespace Anomaly\Streams\Platform\Database\Migration\Console\Command;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Addon\Command\GetAddon;
use Anomaly\Streams\Platform\Database\Migration\Migrator;
use Symfony\Component\Console\Input\InputInterface;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Console\Command;

class ConfigureMigrator
{
    use DispatchesJobs;

    /**
     * The input service.
     *
     * @var InputInterface
     */
    protected $input;

    /**
     * The console command.
     *
     * @var Command
     */
    protected $command;

    /**
     * The migrator service.
     *
     * @var Migrator
     */
    protected $migrator;

    /**
     * Create a new SetAddonPath instance.
     *
     * @param ResetCommand   $command
     * @param InputInterface $input
     * @param Migrator       $migrator
     */
    public function __construct(Command $command, InputInterface $input, Migrator $migrator)
    {
        $this->input     = $input;
        $this->command   = $command;
        $this->migrator  = $migrator;
    }

    /**
     * Handle the command.
     *
     * @param AddonCollection $addons
     */
    public function handle(AddonCollection $addons)
    {
        if (!$addon = $this->input->getOption('addon')) {
            return;
        }

        if (!$addon = $this->dispatch(new GetAddon($addon))) {
            throw new \Exception("Addon could not be found.");
        }

        $this->migrator->setAddon($addon);

        $this->input->setOption('path', $addon->getAppPath('migrations'));
    }
}

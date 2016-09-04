<?php namespace Anomaly\Streams\Platform\Database\Migration\Console\Command;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Addon\Command\GetAddon;
use Anomaly\Streams\Platform\Database\Migration\Migrator;
use Anomaly\Streams\Platform\Database\Migration\MigrationCreator;
use Symfony\Component\Console\Input\InputInterface;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Console\Command;

class ConfigureCreator
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
     * The creator service.
     *
     * @var MigrationCreator
     */
    protected $creator;

    /**
     * Create a new SetAddonPath instance.
     *
     * @param ResetCommand     $command
     * @param InputInterface   $input
     * @param MigrationCreator $creator
     */
    public function __construct(Command $command, InputInterface $input, MigrationCreator $creator)
    {
        $this->input     = $input;
        $this->command   = $command;
        $this->creator   = $creator;
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

        $this->input->setArgument('name', $addon->getNamespace() . '__' . $this->input->getArgument('name'));

        $this->input->setOption('path', $addon->getAppPath('migrations'));

        if (!is_dir($directory = $addon->getPath('migrations'))) {
            mkdir($directory);
        }
    }
}
